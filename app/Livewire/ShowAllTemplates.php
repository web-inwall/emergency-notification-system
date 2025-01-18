<?php

namespace App\Livewire;

use App\Http\Controllers\NotificationTemplateController;
use Livewire\Component;

class ShowAllTemplates extends Component
{
    public $templates;

    public function mount()
    {
        $response = app(NotificationTemplateController::class)->showAllTemplates();
        $this->templates = $response['templates'];
    }
}
