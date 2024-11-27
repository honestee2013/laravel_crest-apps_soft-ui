<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'storage_id',
        'available_quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function getAvailableQuantityUnitAttribute($value) {
        $val = $this->available_quantity;
       /* if ($val != 0)
            return rtrim(rtrim($val, "0"),".") . " ".$this->item->unit->symbol;
        else
            return "0 ".$this->item->unit->symbol;*/
        return $val." ".$this->item->unit->symbol;

    }


}
