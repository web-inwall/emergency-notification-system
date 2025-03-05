<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Twilio\Security\RequestValidator;

class TwilioRequestIsValid
{
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            $twilioToken = config('app.twilio.auth_token');

            if (empty($twilioToken)) {
                throw new Exception('Token not found');
            }

            $requestValidator = new RequestValidator($twilioToken);

            $requestData = $request->toArray();

            if (array_key_exists('bodySHA256', $requestData)) {
                $requestData = $request->getContent();
            }

            $isValid = $requestValidator->validate(
                $request->header('X-Twilio-Signature'),
                $request->fullUrl(),
                $requestData
            );

            if (! $isValid) {
                throw new Exception('Invalid Twilio request');
            }
        } catch (\Throwable $ex) {
            return new Response(['success' => false, 'message' => 'Failed Authentication'], 403);
        }

        return $next($request);
    }
}
