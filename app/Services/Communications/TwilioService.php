<?php

namespace App\Services\Communications;

use Exception;
use Twilio\Rest\Client;

class TwilioService
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

        $this->client = new Client($this->sid, $this->token);

    }

    public function sendMessage($to, $body): array
    {
        $result = ['success' => false, 'data' => [], 'message' => ''];

        try {

            $options = [];
            $options['body'] = $body;
            $options['from'] = $this->from_number;

            $apiResponse = $this->client->messages->create($to, $options);

            $result['data'] = $apiResponse->toArray();

            if (! empty($result['data']['errorCode'])) {
                throw new Exception('Send SMS request failed');
            }
            $result['success'] = true;
            $result['message'] = 'SMS request success';

        } catch (Exception $ex) {
            $result['success'] = false;
            $result['message'] = $ex->getMessage();

        }

        return $result;
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
