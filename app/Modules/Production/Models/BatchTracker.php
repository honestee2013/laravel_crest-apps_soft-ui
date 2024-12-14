<?php
namespace App\Modules\Production\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BatchTracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'status',
        'last_updated_at',
        'remarks',
    ];

    // Relationship with Batch
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    // Relationship with ProductionSteps
    public function steps()
    {
        return $this->hasMany(ProductionStep::class, 'batch_id', 'batch_id');
    }
}
