<?php

namespace App\Http\Controllers;

use App\Interfaces\TwilioSmsControllerInterface;
use App\Models\TwilioSms;
use App\Models\TwilioSmsLog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TwilioSmsController extends Controller implements TwilioSmsControllerInterface
{
    /**
     * This function is a public exposed route that handles twilio requests (from twilio) to inform status changes from messages
     * Format application/x-www-form-urlencoded
     * Method POST
     * Request parameters
     *   SmsSid: SM2xxxxxx
     *   SmsStatus: sent
     *   Body: McAvoy or Stewart? These timelines can get so confusing.
     *   MessageStatus: sent
     *   To: +1512zzzyyyy
     *   MessageSid: SM2xxxxxx
     *   AccountSid: ACxxxxxxx
     *   From: +1512xxxyyyy
     *   ApiVersion: 2010-04-01
     */
    protected $messageNamesData;

    public function statusChanged(Request $request)
    {

        try {
            $logData = [
                'sms_sid' => $request['SmsSid'] ?? null,
                'sms_message_sid' => $request['MessageSid'] ?? null,
                'twilio_sms_id' => null,
                'event' => 'not_categorized',
                'new_status' => $request['MessageStatus'] ?? null,
                'details' => json_encode(($request->all() ?? [])),
            ];

            try {
                if (! isset($request['SmsSid'])) {
                    $logData['event'] = 'invalid_request_sid_not_defined';
                    throw new Exception('Sid not defined. Could not match with system sms.');
                }

                $twilioSms = TwilioSms::select('id', 'sid', 'status')->where('sid', $request['SmsSid'])->first();

                if (empty($twilioSms->id)) {
                    $logData['event'] = 'twilio_sms_not_found';
                    throw new Exception('Twilio sms sid: '.$request['SmsSid'].' was not found.');
                }

                $logData['twilio_sms_id'] = $twilioSms->id;
                $logData['event'] = 'partial_status_changed';

                if (isset($request['SmsStatus']) && $twilioSms->status != $request['SmsStatus']) {
                    $logData['event'] = 'status_changed';
                    $twilioSms->status = $request['SmsStatus'];
                    $twilioSms->save();
                }
            } catch (Exception $ex2) {
                Log::channel('twilio')->error($ex2->getFile().' :: '.$ex2->getMessage());
            }

            TwilioSmsLog::create($logData);

        } catch (Exception $ex) {
            Log::channel('twilio')->error($ex->getFile().' :: '.$ex->getMessage().' :: '.json_encode(($request->all() ?? [])));
        }

        return response(['success' => true], 200);
    }

    /**
     * Handles message_received requests from Twilio
     *
     * Format application/x-www-form-urlencoded
     * Method POST
     * Request parameters
     *  MessageSid	A 34 character unique identifier for the message. May be used to later retrieve this message from the REST API.
     *   SmsSid	Same value as MessageSid. Deprecated and included for backward compatibility.
     *   AccountSid	The 34 character id of the Account this message is associated with.
     *   MessagingServiceSid	The 34 character id of the Messaging Service associated with the message.
     *   From	The phone number or Channel address that sent this message.
     *   To	The phone number or Channel address of the recipient.
     *   Body	The text body of the message. Up to 1600 characters long.
     *   NumMedia	The number of media items associated with your message
     * Observations:
     * All phone numbers in requests from Twilio are in E.164 format if possible. For example, (415) 555-4345 would come through as '+14155554345'. However, there are occasionally cases where Twilio cannot normalize an incoming caller ID to E.164. In these situations, Twilio will report the raw caller ID string.
     */
    public function messageReceived(Request $request)
    {

        try {

            $logData = [
                'sms_sid' => $request['SmsSid'] ?? null,
                'sms_message_sid' => $request['MessageSid'] ?? null,
                'twilio_sms_id' => null,
                'event' => 'not_categorized',
                'details' => json_encode(($request->all() ?? [])),
            ];

            if (! empty($request['SmsSid'])) {

                $logData['event'] = 'message_received';
                $logData['new_status'] = 'received';

                $created = TwilioSms::create([
                    'sid' => $request['SmsSid'] ?? '',
                    'direction' => 'received',
                    'from' => $request['From'] ?? '',
                    'to' => $request['To'] ?? '',
                    'status' => $request['SmsStatus'] ?? 'error',
                    'body' => $request['Body'] ?? '',
                ]);

                if (! empty($created->id)) {
                    $logData['twilio_sms_id'] = $created->id;
                }
            }

            TwilioSmsLog::create($logData);
        } catch (Exception $ex) {
            Log::channel('twilio')->error($ex->getFile().' :: '.$ex->getMessage().' :: '.json_encode(($request->all() ?? [])));
        }

        // Proper TwiML Empty response (Do not auto reply SMS)
        return response('<Response></Response>', 200)->header('Content-Type', 'text/html');
    }
}
