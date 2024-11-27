<?php

namespace App\Modules\Inventory\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_name',
        'name',
        'description',
        'image',
        'parent_id',
        'status',
        'slug',
        'meta_title',
        'meta_description'
    ];



    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

}
