<?php

namespace App\Interfaces;

use App\Http\Requests\FormValidationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

interface MainControllerInterface
{
    public function manageUserNotificationWorkflow(FormValidationRequest $request): View|JsonResponse;
}
