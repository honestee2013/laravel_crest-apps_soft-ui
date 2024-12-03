<?php

namespace App\Modules\Storage\Models;

use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Enterprise\Models\Location;
use App\Modules\Inventory\Models\TransactionType;
use App\Modules\Inventory\Models\InventoryTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollectItem extends InventoryTransaction
{
    use HasFactory;

    protected $table = "inventory_transactions";

}
