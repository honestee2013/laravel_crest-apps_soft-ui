<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Enterprise\Models\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorageType extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'name',
        'description',

    ];




    // Define the relationship with Item
    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }




}
