<?php

namespace App\Modules\Enterprise\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'description',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
