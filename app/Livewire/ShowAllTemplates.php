<?php

namespace App\Livewire;

use App\Interfaces\NotificationTemplateRepositoryInterface;
use Livewire\Component;

class ShowAllTemplates extends Component
{
    public $templates;

    public $selectedTemplateName = null;

    public $selectedTemplateMessage = null;

    public $selectedUserBio = null;

    public $selectedUserLink = null;

    public $selectedUserAddress = null;

    public $users;

    public function mount(NotificationTemplateRepositoryInterface $notificationTemplateRepository)
    {
        $response = $notificationTemplateRepository->getDataTemplates();

        $this->templates = $response['templates'];

        $this->loadUserData(); // Вызов метода для загрузки данных о пользователях
    }

    public function selectTemplate($templateName)
    {
        if ($templateName) {

            $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);

            $this->selectedTemplateName = $selectedTemplate['template_name'];
            $this->selectedTemplateMessage = $selectedTemplate['message'];

            $this->loadUserData($selectedTemplate['users']); // Передача данных о пользователях для загрузки

        } else {
            $this->resetFields();
        }
    }

    private function loadUserData($users = [])
    {
        $userBios = [];
        $userLinks = [];
        $userAddresses = [];

        $userArray = [];

        foreach ($users as $user) {
            $userArray[] = [
                'bio' => $user['bio'],
                'link' => $user['link'],
                'address' => $user['address'],
            ];
        }

        $this->users = $userArray; // Сохраняем массив пользователей в переменной $users

        // Оптимизация: Объединение данных о пользователях только при необходимости
        $this->selectedUserBio = implode(', ', $userBios); // Объединить биографии пользователей в строку
        $this->selectedUserLink = implode(', ', $userLinks); // Объединить ссылки пользователей в строку
        $this->selectedUserAddress = implode(', ', $userAddresses); // Объединить адреса пользователей в строку
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
