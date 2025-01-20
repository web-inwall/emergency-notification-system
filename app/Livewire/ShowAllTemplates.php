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
        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);

        $this->selectedTemplateName = $selectedTemplate['template_name'];
        $this->selectedTemplateMessage = $selectedTemplate['message'];
        $this->selectedUserBio = $selectedTemplate['users'][0]['bio'];
        $this->selectedUserLink = $selectedTemplate['users'][0]['link'];
        $this->selectedUserAddress = $selectedTemplate['users'][0]['address'];
    }
}
