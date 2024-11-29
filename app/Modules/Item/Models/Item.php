<?php

namespace App\Modules\Item\Models;

use App\Modules\Core\Models\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'status_id',
        'weight',
        'dimensions',
        'barcode',
        'unit_cost_price',
        'item_type_id',
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

    public function itemType()
    {
        return $this->belongsTo(ItemType::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function storages()
    {
        return $this->belongsToMany(Storage::class, 'storage_item_limits')
                    ->withPivot('item_limit')
                    ->withTimestamps();
    }





}
