<?php
namespace App\Modules\Production\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionProcess extends Model
{
    protected $fillable = ['name', 'description'];

    public function trackers()
    {
        return $this->hasMany(BatchTracker::class);
    }


    public function logs()
    {
        return $this->hasMany(ProductionProcessLog::class);
    }


}