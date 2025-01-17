<?php

namespace App\Providers;

use App\Services\FileReaderService;
use App\Repositories\UserRepository;
use App\Services\FileReaderInterface;
use App\Services\NotificationService;
use App\Services\NotificationInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Repositories\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(FileReaderInterface::class, FileReaderService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NotificationInterface::class, NotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('valid_csv_content', function ($attribute, $value, $parameters) {
            // Получаем содержимое файла
            $fileContent = file_get_contents($value->getRealPath());
            // Разбиваем содержимое на строки
            $lines = explode("n", $fileContent);

            foreach ($lines as $line) {
                $row = str_getcsv($line);
                if (count($row) >= 1) {
                    return true; // Найдена строка с тремя или более элементами
                }
            }

            return false; // Не найдено строки с тремя или более элементами
        });

        Validator::replacer('valid_csv_content', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':attribute', $attribute, 'Файл :attribute не является файлом CSV');
        });
    }
}