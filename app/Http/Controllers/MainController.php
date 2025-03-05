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
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class MainController extends Controller implements MainControllerInterface
{
    private FileReaderInterface $fileReader;

    private UserRepositoryInterface $userRepository;

    private NotificationRepositoryInterface $notificationRepository;

    private NotificationUserRepositoryInterface $notificationUserRepository;

    private SendNotificationControllerInterface $sendNotificationController;

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

    public function manageUserNotificationWorkflow(FormValidationRequest $request): View|JsonResponse
    {
        try {
            $templateName = $request->input('template_name');
            $message = $request->input('message');

            if ($request->hasFile('file')) {
                $this->validateFileRequest($request);
                $this->processFileData($request, $templateName, $message);
            } else {
                $this->sendNotificationController->processingTemplateData($templateName, $message);
            }

            $resultProcessing = $this->sendNotificationController->getProcessingSuccessfulFailedSend();

            return view('dashboard')->with('resultProcessing', $resultProcessing);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function validateFileRequest(FormValidationRequest $request): void
    {
        $fullFormValidationRequest = new FullFormValidationRequest;
        $validator = Validator::make($request->all(), $fullFormValidationRequest->rules());

        if (! $validator->passes()) {
            throw ValidationException::withMessages($validator->errors()->messages());
        }
    }

    private function processFileData(FormValidationRequest $request, string $templateName, string $message): void
    {
        try {
            $filePath = $request->file('file')->getPathname();
            $csvData = $this->fileReader->readData($filePath);

            $this->userRepository->insertUsers($csvData['data']);

            $notificationObject = $this->notificationRepository->createNotification($templateName, $message);

            $this->notificationUserRepository->createNotificationUsers($csvData, $notificationObject);

            $this->sendNotificationController->processingFormData($csvData, $message);
        } catch (Exception $e) {
            throw new \Exception('Произошла ошибка при обработке файла', 0, $e);
        }
    }
}
