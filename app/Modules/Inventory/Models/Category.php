<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'parent_id',
        'status',
        'slug',
        'meta_title',
        'meta_description'
    ];



    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

}
