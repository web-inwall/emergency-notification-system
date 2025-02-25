<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormValidationRequest;
use App\Http\Requests\FullFormValidationRequest;
use App\Interfaces\FileReaderInterface;
use App\Interfaces\MainControllerInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\SendNotificationServiceInterface;
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

    private $sendNotificationService;

    public function __construct(FileReaderInterface $fileReader, UserRepositoryInterface $userRepository, NotificationRepositoryInterface $notificationRepository, NotificationUserRepositoryInterface $notificationUserRepository, SendNotificationControllerInterface $sendNotificationController, SendNotificationServiceInterface $sendNotificationService)
    {
        $this->fileReader = $fileReader;
        $this->userRepository = $userRepository;
        $this->notificationRepository = $notificationRepository;
        $this->notificationUserRepository = $notificationUserRepository;
        $this->sendNotificationController = $sendNotificationController;
        $this->sendNotificationService = $sendNotificationService;
    }

    public function manageUserNotificationWorkflow(FormValidationRequest $request)
    {
        $templateName = $request->input('template_name');

        // $message = $request->has('userMessage') && $request->input('userMessage') !== null ? $request->input('userMessage') : $request->input('message');

        $message = $request->input('message');

        $requestAllDataForm = new FullFormValidationRequest;

        $validator = Validator::make($request->all(), $requestAllDataForm->rules());

        if ($request->hasFile('file')) {
            if ($validator->passes()) {

                $file = $request->file('file'); // получаем информацию о файле
                $filePath = $file->getPathname();

                try {
                    // Чтение данных из файла
                    $data = $this->fileReader->readData($filePath); // в $data будет массив массивов с ключами и их значениями

                    // Вставка пользователей в БД
                    $this->userRepository->insertUsers($data['data']);

                    // Вставка уведомления в БД
                    $groupNotification = $this->notificationRepository->createNotification($templateName, $message);

                    // Вставка данных в таблицу связи
                    $this->notificationUserRepository->createNotificationUsers($data, $groupNotification);

                    // Отправка уведомлений пользователям
                    $this->sendNotificationController->processingFormData($data, $message);

                } catch (Exception $e) {
                    return response()->json(['error' => $e->getMessage()], 500);
                }
            } else {
                throw ValidationException::withMessages($validator->errors()->messages());
            }
        } else {
            $this->sendNotificationController->processingTemplateData($templateName, $message);
        }

        $resultProcessing = $this->sendNotificationController->getProcessingSuccessfulFailedSend();

        return view('dashboard')->with('resultProcessing', $resultProcessing);
    }
}
