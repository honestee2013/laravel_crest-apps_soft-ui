<?php

namespace App\Modules\Production\Models;

use App\Models\User;
use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Item
{
    use HasFactory;

    protected $table = "items";

    protected $fillable = [
        'name',
        'display_name',
        'description',
    ];




}
