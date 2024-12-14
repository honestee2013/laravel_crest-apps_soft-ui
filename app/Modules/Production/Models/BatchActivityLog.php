<?php

namespace App\Modules\Production\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatchActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'activity_time',
        'activity_type',
        'description',
        'performed_by',
    ];

    protected $casts = [
        'activity_time' => 'datetime',
    ];

    // Relationships
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    // Helper Methods
    public static function logActivity($batchId, $type, $description, $userId = null)
    {
        return self::create([
            'batch_id' => $batchId,
            'activity_time' => now(),
            'activity_type' => $type,
            'description' => $description,
            'performed_by' => $userId,
        ]);
    }
}
