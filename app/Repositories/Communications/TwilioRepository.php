<?php

namespace App\Repositories\Communications;

use App\Interfaces\TwilioRepositoryInterface;
use App\Models\Communications\TwilioSms;
use App\Models\Communications\TwilioSmsLog;

class TwilioRepository implements TwilioRepositoryInterface
{
    public function createSms($result)
    {
        TwilioSms::create([
            'sid' => $result['data']['sid'],
            'direction' => 'sent',
            'from' => $result['data']['from'],
            'to' => $result['data']['to'],
            'status' => $result['data']['status'],
            'body' => $result['data']['body'],
        ]);
    }

    public function createLogData($logData)
    {
        TwilioSmsLog::create($logData);
    }
}
