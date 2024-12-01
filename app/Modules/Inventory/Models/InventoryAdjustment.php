<?php

namespace App\Modules\Inventory\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'transaction_id',
        'adjustment_type',
        'adjusted_quantity',
        'adjustment_reason',
        'adjusted_by',
        'adjustment_date',
    ];


    public function adjustedBy()
    {
        return $this->belongsTo(User::class, 'adjusted_by', 'id');
    }


    public function transaction()
    {
        return $this->belongsTo(InventoryTransaction::class);
    }


}
