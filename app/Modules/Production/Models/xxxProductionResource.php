<?php

namespace App\Modules\Production\Models;

use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;

class ProductionResource extends Item
{
    protected $table = "items";
}
