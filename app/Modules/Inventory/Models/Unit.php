<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'symbol'
    ];




    // Define the relationship with Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
