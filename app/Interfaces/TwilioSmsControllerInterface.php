<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface TwilioSmsControllerInterface
{
    public function statusChanged(Request $request): Response;

    public function messageReceived(Request $request): Response;
}
