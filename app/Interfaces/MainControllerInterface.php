<?php

namespace App\Interfaces;

use App\Http\Requests\FormValidationRequest;

interface MainControllerInterface
{
    public function manageUserNotificationWorkflow(FormValidationRequest $request);
}
