<?php
namespace App\Modules\Production\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionLog extends Model
{
    protected $fillable = ['production_order_id', 'batch_id', 'activity', 'details', 'timestamp'];

    public function productionOrder()
    {
        return $this->belongsTo(ProductionOrder::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
}
