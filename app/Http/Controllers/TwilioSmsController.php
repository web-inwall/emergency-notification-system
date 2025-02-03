<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class TwilioSmsController extends Controller
{
    /**
     * Test sms send
     *
     * @return mixed
     */
    public function sendTest(Request $request)
    {
        try {

            // Make sure it is E.164 formatting
            $toPhoneNumber = 'TO_PHONE_NUMBER_YOU_ARE_TESTING';
            $sendResult = app('TwilioService')->sendMessage($toPhoneNumber, 'Hi, this is a test');
            if (! isset($sendResult['success']) || ! $sendResult['success']) {
                throw new Exception(($sendResult['message'] ?? ''));
            }

            return $sendResult;
        } catch (Exception $ex) {
            return 'Send SMS Failed - '.$ex->getMessage();
        }
    }
}
