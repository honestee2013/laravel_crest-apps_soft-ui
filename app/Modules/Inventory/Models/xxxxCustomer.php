<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [

    ];




    // Define the relationship with Item
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

}
