<?php

namespace App\Modules\Dashboard\Livewire;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;



class DashboardManager extends Component
{



    public $timeDuration = "this_month";



    protected $listeners = [
        //'configChangedEvent' => '$refresh',
    ];



    public function mount()
    {

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
