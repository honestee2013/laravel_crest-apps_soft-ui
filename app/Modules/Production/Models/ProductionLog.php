<?php
namespace App\Modules\Production\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionLog extends Model
{
    protected $fillable = ['production_order_request_id', 'production_batch_id', 'activity', 'details', 'timestamp'];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrderRequest::class);
    }

    public function batch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
