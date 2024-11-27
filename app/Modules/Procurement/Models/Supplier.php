<?php

namespace App\Modules\Procurement\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'name',
        'company_name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'contact_person',
        'website',
        'supplier_type_id',
        'notes',
        'date_of_birth',
        'registered_at',
        'status_id',
    ];






    public function supplierType()
    {
        return $this->belongsTo(SupplierType::class);
    }







}
