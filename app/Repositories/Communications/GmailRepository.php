<?php

namespace App\Repositories\Communications;

use App\Interfaces\GmailRepositoryInterface;
use App\Models\Communications\GmailLog;

class GmailRepository implements GmailRepositoryInterface
{
    public function createLogData(string $recipient, string $status): void
    {
        GmailLog::create([
            'email' => $recipient,
            'status' => $status,
        ]);
    }
}
