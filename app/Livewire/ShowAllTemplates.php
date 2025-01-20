<?php

namespace App\Livewire;

use App\Http\Controllers\NotificationTemplateController;
use Livewire\Component;

class ShowAllTemplates extends Component
{
    public $templates;
    public $selectedTemplateName;
    public $selectedTemplateMessage;
    public $selectedUserBio;
    public $selectedUserLink;
    public $selectedUserAddress;

    public function mount()
    {
        $this->selectedTemplateName = null;
        $this->selectedTemplateMessage = null;
        $this->selectedUserBio = null;
        $this->selectedUserLink = null;
        $this->selectedUserAddress = null;

        $response = app(NotificationTemplateController::class)->showAllTemplates();
        $this->templates = $response['templates']; //содержит массив массивов информации о шаблоне: имя, адрес и тд.
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

    public function updatedSelectedTemplateName($value)
    {
        if (!empty($value)) {
            $selectedTemplate = collect($this->templates)->firstWhere('template_name', $value);

            $this->selectedTemplateMessage = $selectedTemplate['message'];
            $this->selectedUserBio = $selectedTemplate['users'][0]['bio'];
            $this->selectedUserLink = $selectedTemplate['users'][0]['link'];
            $this->selectedUserAddress = $selectedTemplate['users'][0]['address'];
        }
    }


    public function render()
    {
        return view('livewire.show-all-templates');
    }
}
