<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormValidationRequest;
use App\Http\Requests\FullFormValidationRequest;
use App\Interfaces\FileReaderInterface;
use App\Interfaces\MainControllerInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class MainController extends Controller implements MainControllerInterface
{
    private $fileReader;

    private $userRepository;

    private $notificationRepository;

    private $notificationUserRepository;

    private $sendNotificationController;

    public function __construct(
        FileReaderInterface $fileReader,
        UserRepositoryInterface $userRepository,
        NotificationRepositoryInterface $notificationRepository,
        NotificationUserRepositoryInterface $notificationUserRepository,
        SendNotificationControllerInterface $sendNotificationController
    ) {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationUserRepository = $notificationUserRepository;
        $this->sendNotificationController = $sendNotificationController;
    }

    public function manageUserNotificationWorkflow(FormValidationRequest $request)
    {
        $templateName = $request->input('template_name');
        $message = $request->input('message');

        if ($request->hasFile('file')) {
            $this->validateFileRequest($request);
            $this->processFileData($request, $templateName, $message);
        } else {
            $this->sendNotificationController->processingTemplateData($templateName, $message);
        }

        $resultProcessing = $this->sendNotificationController->getProcessingSuccessfulFailedSend();

        return View('dashboard')->with('resultProcessing', $resultProcessing);
    }

    private function validateFileRequest(FormValidationRequest $request)
    {
        $fullFormValidationRequest = new FullFormValidationRequest;
        $validator = Validator::make($request->all(), $fullFormValidationRequest->rules());

        if (! $validator->passes()) {
            throw ValidationException::withMessages($validator->errors()->messages());
        }
    }

    private function processFileData(FormValidationRequest $request, string $templateName, string $message)
    {
        try {
            $filePath = $request->file('file')->getPathname();
            $csvData = $this->fileReader->readData($filePath);

            $this->userRepository->insertUsers($csvData['data']);

            $notificationObject = $this->notificationRepository->createNotification($templateName, $message);

            $this->notificationUserRepository->createNotificationUsers($csvData, $notificationObject);

            $this->sendNotificationController->processingFormData($csvData, $message);
        } catch (Exception $e) {
            // Логирование исключения
            // Возвращение более информативного сообщения об ошибке
            return response()->json(['error' => 'Произошла ошибка при обработке файла'], 500);
        }
    }
}
