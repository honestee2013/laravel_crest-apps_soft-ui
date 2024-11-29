<?php

namespace App\Modules\Item\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Modules\Core\Traits\Database\DatabaseQueryTrait;

class Unit extends Model
{
    use HasFactory, DatabaseQueryTrait;

    protected $fillable = [
        'display_name',
        'name',
        'description',
        'symbol'
    ];


    public function getXxxAttribute() {
        return $this->name." ".$this->symbol;
    }




    // Define the relationship with Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
