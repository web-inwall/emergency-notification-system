<?php

namespace App\Http\Controllers;

use App\Interfaces\TwilioSmsControllerInterface;
use App\Models\TwilioSms;
use App\Models\TwilioSmsLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class TwilioSmsController extends Controller implements TwilioSmsControllerInterface
{
    protected mixed $messageNamesData;

    public function statusChanged(Request $request): Response
    {
        try {
            $logData = [
                'sms_sid' => $request->input('SmsSid'),
                'sms_message_sid' => $request->input('MessageSid'),
                'twilio_sms_id' => null,
                'event' => 'not_categorized',
                'new_status' => $request->input('MessageStatus'),
                'details' => json_encode($request->all()),
            ];

            try {
                if (! $request->has('SmsSid')) {
                    $logData['event'] = 'invalid_request_sid_not_defined';
                    throw new Exception('Sid not defined. Could not match with system sms.');
                }

                $twilioSms = TwilioSms::select('id', 'sid', 'status')->where('sid', $request->input('SmsSid'))->first();

                if (! $twilioSms) {
                    $logData['event'] = 'twilio_sms_not_found';
                    throw new Exception('Twilio sms sid: '.$request->input('SmsSid').' was not found.');
                }

                $logData['twilio_sms_id'] = $twilioSms->id;
                $logData['event'] = 'partial_status_changed';

                if ($request->has('SmsStatus') && $twilioSms->status != $request->input('SmsStatus')) {
                    $logData['event'] = 'status_changed';
                    $twilioSms->status = $request->input('SmsStatus');
                    $twilioSms->save();
                }
            } catch (Exception $ex2) {
                Log::channel('twilio')->error($ex2->getFile().' :: '.$ex2->getMessage());
            }

            TwilioSmsLog::create($logData);
        } catch (Exception $e) {
            Log::channel('twilio')->error($e->getFile().' :: '.$e->getMessage().' :: '.json_encode($request->all()));
        }

        return response(['success' => true], 200);
    }

    public function messageReceived(Request $request): Response
    {
        try {
            $logData = [
                'sms_sid' => $request->input('SmsSid'),
                'sms_message_sid' => $request->input('MessageSid'),
                'twilio_sms_id' => null,
                'event' => 'not_categorized',
                'details' => json_encode($request->all()),
            ];

            if ($request->has('SmsSid')) {
                $logData['event'] = 'message_received';
                $logData['new_status'] = 'received';

                $created = TwilioSms::create([
                    'sid' => $request->input('SmsSid'),
                    'direction' => 'received',
                    'from' => $request->input('From'),
                    'to' => $request->input('To'),
                    'status' => $request->input('SmsStatus') ?? 'error',
                    'body' => $request->input('Body'),
                ]);

                if ($created->id) {
                    $logData['twilio_sms_id'] = $created->id;
                }
            }

            TwilioSmsLog::create($logData);
        } catch (Exception $e) {
            Log::channel('twilio')->error($e->getFile().' :: '.$e->getMessage().' :: '.json_encode($request->all()));
        }

        return response('<Response></Response>', 200)->header('Content-Type', 'text/html');
    }
}
