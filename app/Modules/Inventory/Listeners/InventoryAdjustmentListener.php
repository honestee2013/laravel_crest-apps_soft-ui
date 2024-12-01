<?php

namespace App\Modules\Inventory\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use  App\Modules\Core\Events\DataTableFormEvent;

use App\Modules\Inventory\Models\TransactionType;
use App\Modules\Inventory\Services\InventoryService;
use App\Modules\Core\Events\DataTableFormAfterCreateEvent;
use App\Modules\Inventory\Events\InventoryAdjustmentEvent;
use App\Modules\Inventory\Events\InventoryTransactionEvent;
use App\Modules\Inventory\Models\InventoryTransaction;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use App\Modules\Inventory\Models\InventoryAdjustment;


class InventoryAdjustmentListener
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
    public function handle(InventoryAdjustmentEvent $event): void
    {

        if ($event->eventName == "AfterCreate"){// || $event->eventName == "AfterUpdate")  {
            $this->createNewAdjustmentTransaction($event);
            $this->adjustmentTransactionInventory($event);
        }

    }



    private function createNewAdjustmentTransaction($event) {
        $data = $event->newRecord;
        $transactionType = $this->getTransactionType($data);
        // Find the $transaction reference using the supplied id: (transaction_id)
        if ($transactionType) {
            $transac = InventoryTransaction::findOrFail($data["transaction_id"]);
            // Duplicate the $copiedTransaction reference
            $copiedTransaction = $transac->replicate();

            // Associate the "Transaction Type" found above with the  transaction reference
            $copiedTransaction->transaction_type_id = $transactionType->id;
            // Assign the "Reference Number" of the transaction reference with the
            $copiedTransaction->reference_number = $transac->transaction_id;
            // Assign the "Transaction Date" to the current date and time
            $copiedTransaction->transaction_date = \Now();
            // Assign the "Quantity" to the transaction reference
            $copiedTransaction->quantity = $data["adjusted_quantity"];
            $copiedTransaction->save();
            $data["uuid"] = $copiedTransaction->uuid;
            InventoryAdjustment::findOrFail($data["id"])->update($data);
        }
    }


    private function adjustmentTransactionInventory($event) {
        $data = $event->newRecord;
        $transactionType = $this->getTransactionType($data);
        if ($transactionType) {
            $transac = InventoryTransaction::findOrFail($data["transaction_id"]);
            // Duplicate the $copiedTransaction reference

            $inventoryService = new InventoryService();
            $operation = ($event->newRecord["adjustment_type"] == "Addition")? "add" : "subtract";
            $inventoryService->updateInventory($transac->item_id,
                $transac->storage_id, $data["adjusted_quantity"], $operation);

        }
    }



    private function getTransactionType($data) {
        // Find the "transaction_type" using the supplied data: (Adjustment In/Adjustment Out)
        $transactionTypeName = "adjustment_in";

        if ($data["adjustment_type"] == "Subtraction")
            $transactionTypeName = "adjustment_out";

        $transactionType = TransactionType::where("name", $transactionTypeName)->first();
        return $transactionType;
    }



}
