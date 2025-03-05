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

    public function mount(NotificationTemplateRepositoryInterface $notificationTemplateRepository): void
    {
        $response = $notificationTemplateRepository->getDataTemplates();

        $this->templates = $response['templates'];

        $this->loadUserData();
    }

    public function selectTemplate(string $templateName): void
    {
        if ($templateName) {

            $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);

            $this->selectedTemplateName = $selectedTemplate['template_name'];
            $this->selectedTemplateMessage = $selectedTemplate['message'];

            $this->loadUserData($selectedTemplate['users']);
        } else {
            $this->resetFields();
        }
    }

    private function loadUserData(array $users = []): void
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

        $this->users = $userArray;

        $this->selectedUserBio = implode(', ', $userBios);
        $this->selectedUserLink = implode(', ', $userLinks);
        $this->selectedUserAddress = implode(', ', $userAddresses);
    }

    private function resetFields(): void
    {
        $this->selectedTemplateName = null;
        $this->selectedTemplateMessage = null;
        $this->selectedUserBio = null;
        $this->selectedUserLink = null;
        $this->selectedUserAddress = null;
    }
}
