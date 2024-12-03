<?php

namespace App\Modules\Inventory\Services;

use App\Modules\Inventory\Models\Inventory;

use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Update inventory records dynamically
     *
     * @param int $itemId
     * @param int $locationId
     * @param float $quantityChange
     * @param string $operation ('add' or 'subtract')
     * @return Inventory
     * @throws \Exception
     */
    public function updateInventory(int $itemId, int $storageId, float $quantityChange, string $operation = 'add'): Inventory
    {
        return DB::transaction(function () use ($itemId, $storageId, $quantityChange, $operation) {
            // Fetch or create the inventory record
            $inventory = Inventory::firstOrCreate(
                ['item_id' => $itemId, 'storage_id' => $storageId],
                ['available_quantity' => 0]
            );
//dd($inventory);
            // Perform the operation
            if ($operation === 'add') {
                $inventory->available_quantity += $quantityChange;
            } elseif ($operation === 'subtract') {
                if ($inventory->available_quantity < $quantityChange) {
                    throw new \Exception("Insufficient inventory ");//for item $itemId at location $locationId.");
                }
                $inventory->available_quantity -= $quantityChange;
            } else {
                throw new \InvalidArgumentException('Invalid operation. Use "add" or "subtract".');
            }

            $inventory->save();

            return $inventory;
        });
    }
}
