<?php

namespace App\Modules\Production\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductionStep extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'process_id',
        'step_name',
        'started_at',
        'ended_at',
        'status',
        'notes',
        'resources_consumed',
        'updated_by',
    ];

    protected $casts = [
        'resources_consumed' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    // Relationships
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function process()
    {
        return $this->belongsTo(ProductionProcess::class, 'process_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Helper Methods
    public function startStep()
    {
        $this->update([
            'status' => 'In Progress',
            'started_at' => now(),
        ]);
    }

    public function completeStep()
    {
        $this->update([
            'status' => 'Completed',
            'ended_at' => now(),
        ]);
    }

    public function addResources(array $resources)
    {
        $this->update([
            'resources_consumed' => array_merge($this->resources_consumed ?? [], $resources),
        ]);
    }
}
