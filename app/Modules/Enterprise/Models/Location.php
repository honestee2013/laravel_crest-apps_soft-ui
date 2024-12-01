<?php

namespace App\Modules\Enterprise\Models;

use App\Modules\Inventory\Models\Store;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'description'
    ];


    public function companies()
    {
        return $this->hasMany(Company::class, 'location_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'location_id', 'id');
    }


}
