<?php

namespace App\Modules\Production\Models;


use Illuminate\Database\Eloquent\Model;
use App\Modules\Production\Models\ProductionOrder;


class Batch extends Model
{
    protected $fillable = ['batch_number', 'production_order_id', 'status', 'output_quantity'];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class);
    }


    public function optionList(){
        return ["test1", "test2"];
    }
}
