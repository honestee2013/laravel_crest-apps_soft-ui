<?php

namespace App\Modules\Production\Models;

use App\Modules\Item\Models\Item;
use App\Modules\Core\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class ProductionBatchOutput extends Pivot
{
    use HasFactory;

    protected $table = "production_batch_outputs";

    protected $fillable = [
        'production_batch_id',
        'item_id',
        'actual_quantity',
        'planned_quantity',
    ];

    public function batch()
    {
        return $this->belongsTo(ProductionBatch::class, 'production_batch_id');
    }


    public function item()
    {
        return $this->belongsTo(Item::class, "item_id");
    }




}
