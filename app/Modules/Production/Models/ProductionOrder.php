<?php

namespace App\Modules\Production\Models;


use App\Models\User;
use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Enterprise\Models\Department;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'order_number',

        'batch_number',
        'item_id',
        'department_id',

        'status',
        'planned_quantity',
        'actual_quantity',

        'expected_start_time',
        'expected_end_time',
        'completed_at',


        'notes',

        'created_by',  // User who generated the order
        'supervisor_id' // Assigned supervisor or manager
    ];

    // Relationship to the item being produced
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relationship to the department responsible for production
    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    /*public function expectedItems()
    {
        return $this->hasMany(ProductionOrderItem::class)->where('type', 'expected');
    }

    public function actualItems()
    {
        return $this->hasMany(ProductionOrderItem::class)->where('type', 'actual');
    }



    public function batches()
    {
        return $this->hasMany(Batch::class);
    }*/







    // Generates a unique batch number for the production order
    public static function boot()
    {
        parent::boot();

        static::creating(function ($productionOrder) {
            $productionOrder->batch_number = self::generateBatchNumber();
        });
    }

    // Function to generate a unique batch number
    public static function generateBatchNumber()
    {
        return 'BATCH-' . strtoupper(uniqid());
    }
}
