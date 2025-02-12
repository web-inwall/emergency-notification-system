<?php

namespace App\Services\Communications;

use App\Models\TwilioSms;
use App\Models\TwilioSmsLog;
use Exception;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioSmsService
{
    /**
     * Twilio Client
     */
    protected $client;

    /**
     * Twilio instance parameters
     */
    protected $sid;

    protected $token;

    protected $from_number;

    /**
     * Status Callback Url
     */
    protected $status_callback_url;

    /**
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function __construct()
    {
        $this->sid = config('app.twilio.sid');
        $this->token = config('app.twilio.auth_token');
        $this->from_number = config('app.twilio.from_number');
        $this->status_callback_url = route('api.twilio.status-changed');

        $this->client = new Client($this->sid, $this->token);
    }

    public function sendMessage($to, $body): array
    {
        $result = ['success' => false, 'data' => [], 'message' => '', 'twilio_sms_id' => null];

        try {

            $options = [];
            $options['body'] = $body;
            $options['from'] = $this->from_number;
            $options['statusCallback'] = $this->status_callback_url;

            $apiResponse = $this->client->messages->create($to, $options);

            $result['data'] = $apiResponse->toArray();

            if (! empty($result['data']['errorCode'])) {
                throw new Exception('Send sms request failed');
            }
            $result['success'] = true;

            $createdSms = TwilioSms::create([
                'sid' => $result['data']['sid'],
                'direction' => 'sent',
                'from' => $result['data']['from'],
                'to' => $result['data']['to'],
                'status' => $result['data']['status'],
                'body' => $result['data']['body'],
            ]);

            $result['twilio_sms_id'] = $createdSms->id ?? null;

            $this->log([
                'twilio_sms_id' => $createdSms->id ?? null,
                'sms_sid' => $result['data']['sid'] ?? null,
                'event' => 'send_sms_request',
                'new_status' => $result['data']['status'] ?? null,
                'details' => $result['data'],
            ]);

        } catch (Exception $ex) {
            $result['success'] = false;
            $result['message'] = $ex->getMessage();
            $result['data']['error_message'] = $result['message'];
            $this->log([
                'twilio_sms_id' => null,
                'sms_sid' => $result['data']['sid'] ?? null,
                'event' => 'send_sms_request_error',
                'new_status' => $result['data']['status'] ?? null,
                'details' => $result['data'] ?? [],
            ]);
        }

        return $result;
    }

    private function log($data)
    {
        try {
            if (empty($data)) {
                throw new Exception('Invalid log data');
            }

            $logData = [
                'twilio_sms_id' => $data['twilio_sms_id'] ?? null,
                'sms_sid' => $data['sms_sid'] ?? null,
                'sms_message_sid' => $data['sms_sid'] ?? null,
                'event' => $data['event'] ?? 'generic_error',
                'new_status' => $data['new_status'] ?? null,
                'details' => json_encode(($data['details'] ?? [])),
            ];

            TwilioSmsLog::create($logData);

        } catch (Exception $ex) {
            // NOTICE: Should probably create a log channel just for Twilio
            Log::channel('single')->error($ex->getFile().' :: '.$ex->getLine().' :: '.$ex->getMessage());
        }

    }

    /**
     * Get Twilio Client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }
}
