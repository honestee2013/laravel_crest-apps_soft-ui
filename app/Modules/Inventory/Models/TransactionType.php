<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Modules\Core\Traits\Database\DatabaseQueryTrait;


class TransactionType extends Model
{
    use HasFactory, DatabaseQueryTrait;

    protected $fillable = [
        'display_name',
        'name',
        'description',
        'storage_direction',
    ];




    // Define the relationship with Item
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

   


}
