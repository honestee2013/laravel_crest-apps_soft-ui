<?php

namespace App\Modules\Storage\Models;

use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Enterprise\Models\Location;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location_id',
        'storage_type',
        'opening_hours',
        'closing_hours',
        'storage_type_id',
    ];




    // Define the relationship with Item
    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }

    public function storageType()
    {
        return $this->belongsTo(Storage::class);
    }



    public function items()
    {
        return $this->belongsToMany(Item::class, 'storage_item_limits')
                    ->withPivot('item_limit')
                    ->withTimestamps();
    }



}
