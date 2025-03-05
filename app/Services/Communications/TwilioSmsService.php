<?php

namespace App\Services\Communications;

use App\Interfaces\TwilioRepositoryInterface;
use App\Interfaces\TwilioSmsServiceInterface;
use Exception;
use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class TwilioSmsService implements TwilioSmsServiceInterface
{
    protected TwilioRepositoryInterface $twilioRepositoryInterface;

    protected Client $client;

    protected string $sid;

    protected string $token;

    protected string $from_number;

    protected string $status_callback_url;

    public function __construct(TwilioRepositoryInterface $twilioRepositoryInterface)
    {
        $this->twilioRepositoryInterface = $twilioRepositoryInterface;

        $this->sid = config('app.twilio.sid');
        $this->token = config('app.twilio.auth_token');
        $this->from_number = config('app.twilio.from_number');
        $this->status_callback_url = route('api.twilio.status-changed');

        $this->client = new Client($this->sid, $this->token);
    }

    public function sendMessage(string $to, string $body): array
    {
        $result = [
            'success' => false,
            'data' => [],
            'message' => '',
            'twilio_sms_id' => null,
        ];

        try {
            $options = [
                'body' => $body,
                'from' => $this->from_number,
                'statusCallback' => $this->status_callback_url,
            ];

            $apiResponse = $this->client->messages->create($to, $options);

            $result['data'] = $apiResponse->toArray();

            if (! empty($result['data']['errorCode'])) {
                throw new Exception('Send sms request failed');
            }

            $result['success'] = true;

            $createdSms = $this->twilioRepositoryInterface->createSms($result);

            $result['twilio_sms_id'] = $createdSms->id ?? null;

            $this->log([
                'twilio_sms_id' => $createdSms->id ?? null,
                'sms_sid' => $result['data']['sid'] ?? null,
                'event' => 'send_sms_request',
                'new_status' => $result['data']['status'] ?? null,
                'details' => $result['data'],
            ]);
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
            $result['data']['error_message'] = $result['message'];

            $this->log([
                'twilio_sms_id' => null,
                'sms_sid' => $result['data']['sid'] ?? null,
                'event' => 'send_sms_request_error',
                'new_status' => $result['data']['status'] ?? null,
                'details' => $result['data'] ?? [],
            ]);

            Log::channel('single')->error($e->getFile().' :: '.$e->getLine().' :: '.$e->getMessage());
        }

        return $result;
    }

    private function log(array $data): void
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

            $this->twilioRepositoryInterface->createLogData($logData);
        } catch (Exception $e) {
            Log::channel('single')->error($e->getFile().' :: '.$e->getLine().' :: '.$e->getMessage());
        }
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}
