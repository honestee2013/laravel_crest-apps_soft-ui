<?php

namespace App\Modules\Inventory\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'managed_by', 'created_by', 'updated_by', 'name', 'contact_person', 'phone',
        'email', 'address', 'city', 'country', 'supplier_type', 'notes'
    ];

    // Link to the User who is the supplier (Account Management)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Link to the internal User managing this supplier
    public function manager()
    {
        return $this->belongsTo(User::class, 'managed_by');
    }

    // Link to the User who created the supplier record (Audit Trail)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Link to the User who last updated the supplier record (Audit Trail)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
