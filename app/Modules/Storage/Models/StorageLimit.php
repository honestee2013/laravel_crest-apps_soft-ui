<?php
namespace App\Modules\Storage\Models;

use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StorageLimit extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_id',
        'item_id',
        'min_allowed',
        'max_allowed',
    ];

    // Define relationship to Storage
    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }

    // Define relationship to Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Accessor for storage name
    public function getStorageNameAttribute()
    {
        return $this->storage ? $this->storage->name : null;
    }

    // Accessor for item name
    public function getItemNameAttribute()
    {
        return $this->item ? $this->item->name : null;
    }
}

