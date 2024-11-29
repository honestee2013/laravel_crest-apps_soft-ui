<?php

namespace App\Modules\Inventory\Livewire\Inventories;


use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Modules\Core\Traits\DataTable\DataTableControlsTrait;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;



class InventoryManager extends Component
{

    protected $listeners = [
        'afterUpdateInventoryTransactionEvent' => 'handleAfterUpdateInventoryTransaction',
    ];

    public function handleAfterUpdateInventoryTransaction() {
        dd("Success for afterUpdateInventoryTransactionEvent");
    }

}
