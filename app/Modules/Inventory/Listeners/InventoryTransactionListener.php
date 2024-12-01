<?php

namespace App\Modules\Inventory\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use  App\Modules\Core\Events\DataTableFormEvent;

use App\Modules\Inventory\Models\TransactionType;
use App\Modules\Inventory\Services\InventoryService;
use App\Modules\Core\Events\DataTableFormAfterCreateEvent;
use App\Modules\Inventory\Events\InventoryTransactionEvent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;


class InventoryTransactionListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InventoryTransactionEvent $event): void
    {

        if ($event->eventName == "AfterUpdate" || $event->eventName == "AfterCreate")  {
            $inventoryService = new InventoryService();
            $operation = (TransactionType::findOrFail($event->newRecord["transaction_type_id"])->storage_direction === "IN")? "add" : "subtract";
            $inventoryService->updateInventory($event->newRecord["item_id"], $event->newRecord["storage_id"], $event->newRecord["quantity"], $operation);
        }

    }
}
