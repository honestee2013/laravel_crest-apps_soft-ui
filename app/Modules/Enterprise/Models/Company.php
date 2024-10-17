<?php

namespace App\Modules\Enterprise\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo',
        'name',
        'location_id',
        'phone',
        'email',
        'website',
        'address',
        'postal_code',
        'status',
        'description',
        'date_established',
    ];

    public function departments()
    {
        return $this->hasMany(Department::class);
    }


    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }



}
