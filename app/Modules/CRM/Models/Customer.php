<?php

namespace App\Modules\CRM\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';

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
        'customer_type_id',
        'notes',
        'date_of_birth',
        'registered_at',
        'status_id',
    ];



    /**
     * Get the user associated with the customer.
     */
    public function customerType()
    {
        return $this->belongsTo(CustomerType::class);
    }



}

