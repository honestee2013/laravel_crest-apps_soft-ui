<?php

namespace App\Modules\Dashboard\Livewire;


use Livewire\Component;

use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;



class DashboardManager extends Component
{

    protected $listeners = [
        'recordSavedEvent' => '$refresh',
    ];



    public function mount()
    {

    }


    public function render()
    {
        return view('dashboard.views::dashboard-manager', []);
    }

}
