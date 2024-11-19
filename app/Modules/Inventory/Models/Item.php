<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'unit_id',
        'sku',
        'unit_selling_price',
        'image',
        'status',
        'weight',
        'dimensions',
        'barcode',
        'unit_cost_price',
        'item_type',
    ];



    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    // Define the relationship with Unit
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'storage_item_limits')
                    ->withPivot('item_limit')
                    ->withTimestamps();
    }





}
