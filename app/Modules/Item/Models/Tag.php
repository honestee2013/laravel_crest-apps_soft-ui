<?php

namespace App\Modules\Item\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;


    protected $fillable = [
        'display_name',
        'name',
        'description',
        'slug',
        'item_id'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
