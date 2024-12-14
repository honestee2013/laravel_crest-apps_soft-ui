<?php

namespace App\Modules\Production\Models;

use App\Modules\Item\Models\Item;
use App\Modules\Core\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class BatchProductItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'item_id',
        'quantity_produced',
        'expected_quantity',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }


}
