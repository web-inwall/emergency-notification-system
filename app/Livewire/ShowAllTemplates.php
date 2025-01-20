<?php

namespace App\Livewire;

use App\Http\Controllers\NotificationTemplateController;
use Livewire\Component;

class ShowAllTemplates extends Component
{
    public $templates;
    public $selectedTemplateName = null;
    public $selectedTemplateMessage = null;
    public $selectedUserBio = null;
    public $selectedUserLink = null;
    public $selectedUserAddress = null;

    public function mount()
    {
        $response = app(NotificationTemplateController::class)->showAllTemplates();
        $this->templates = $response['templates']; //содержит массив массивов информации о шаблоне: имя, адрес и тд
    }

    public function selectTemplate($templateName)
    {
        if ($templateName) {
            $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);

            $this->selectedTemplateName = $selectedTemplate['template_name'];
            $this->selectedTemplateMessage = $selectedTemplate['message'];

            $userBios = [];
            $userLinks = [];
            $userAddresses = [];

            // Оптимизация: Загрузка данных о пользователях только при необходимости
            foreach ($selectedTemplate['users'] as $user) {
                $userBios[] = $user['bio'];
                $userLinks[] = $user['link'];
                $userAddresses[] = $user['address'];
            }

            // Оптимизация: Объединение данных о пользователях только при необходимости
            $this->selectedUserBio = implode(', ', $userBios); // Объединить биографии пользователей в строку
            $this->selectedUserLink = implode(', ', $userLinks); // Объединить ссылки пользователей в строку
            $this->selectedUserAddress = implode(', ', $userAddresses); // Объединить адреса пользователей в строку
        } else {
            $this->resetFields();
        }
    }


    private function resetFields()
    {
        $this->selectedTemplateName = null;
        $this->selectedTemplateMessage = null;
        $this->selectedUserBio = null;
        $this->selectedUserLink = null;
        $this->selectedUserAddress = null;
    }
}
