<?php

namespace App\Modules\Dashboard\Livewire;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;
use App\Modules\Production\Models\ProductionProcess;

class DashboardManager extends Component
{



    public $timeDuration = "this_month";
    public $selectedProcessId;
    public $selectedProcessName;


    protected $listeners = [
        //'configChangedEvent' => '$refresh',
    ];



    public function mount()
    {
        $defaultProcess = ProductionProcess::where("name", "Parboiling")->first();
        $this->selectedProcessName = $defaultProcess->name;
        $this->selectedProcessId = $defaultProcess->id;
    }

    public function updatedSelectedProcessId($newId) {
        $this->selectedProcessName = ProductionProcess::findOrFail($newId)->name;

        //$this->dispatch("configChangedEvent", ["recordName" => "Completed " . ucfirst($this->selectedProcessName) ]);
        $this->dispatch("configChangedEvent", ["filters" => [['production_process_id', '=', $newId ?? 0]] ]);
    }




    public function updatedTimeDuration()
    {
        $this->dispatch("configChangedEvent", ["timeDuration" => $this->timeDuration]);
    }









    public function render()
    {
        return view('dashboard.views::dashboard-manager', []);
    }

}
