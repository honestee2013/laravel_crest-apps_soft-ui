<?php

namespace App\Modules\Enterprise\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];


    public function companies()
    {
        return $this->hasMany(Company::class, 'location_id', 'id');
    }


}