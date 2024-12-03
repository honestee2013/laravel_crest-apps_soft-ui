<?php

namespace App\Modules\Storage\Listeners;

use Illuminate\Support\Facades\Event;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Modules\Storage\Events\IssueItemEvent;

use  App\Modules\Core\Events\DataTableFormEvent;
use App\Modules\Inventory\Models\TransactionType;
use App\Modules\Storage\Events\AdjustStorageEvent;
use App\Modules\Inventory\Services\InventoryService;
use App\Modules\Core\Events\DataTableFormAfterCreateEvent;
use App\Modules\Inventory\Events\InventoryAdjustmentEvent;
use App\Modules\Inventory\Events\InventoryTransactionEvent;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use App\Modules\Inventory\Listeners\InventoryTransactionListener;


class AdjustStorageListener
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


    /**
     * Handle the event.
     */
    public function handle(AdjustStorageEvent $event): void
    {
        // Dispatch the new event
        Event::dispatch(new InventoryAdjustmentEvent(
            $event->eventName,
            $event->oldRecord,
            $event->newRecord
        ));

        // Alternatively, you can do this without using the Event facade:
        // InventoryTransactionEvent::dispatch($event->eventName, $event->oldRecord, $event->newRecord);
    }




}
