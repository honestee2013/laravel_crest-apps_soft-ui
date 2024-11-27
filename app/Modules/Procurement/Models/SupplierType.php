<?php

namespace App\Modules\Procurement\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierType extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name',
        'name',
        'description',

    ];





    public function supliers()
    {
        return $this->hasMany(Supplier::class);
    }


}
