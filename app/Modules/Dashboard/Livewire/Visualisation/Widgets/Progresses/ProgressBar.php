<?php

namespace App\Modules\Dashboard\Livewire\Visualisation\Widgets\Progresses;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;



class ProgressBar extends Component
{

    protected $listeners = [
        'recordSavedEvent' => '$refresh',
    ];


    public $progress; // Progress value (0–100)
    public $label;    // Label for the progress bar
    public $color;    // Bootstrap color class (e.g., primary, success)

    public function mount($progress = 0, $label = '', $color = 'primary')
    {
        $this->progress = $progress;
        $this->label = $label;
        $this->color = $color;
    }

    public function incrementProgress($amount = 10)
    {
        $this->progress = min(100, $this->progress + $amount);
    }

    public function decrementProgress($amount = 10)
    {
        $this->progress = max(0, $this->progress - $amount);
    }


    public function render()
    {
        return view('dashboard.views::components.visualisation.widgets.progresses.progress-bar');

    }

}
