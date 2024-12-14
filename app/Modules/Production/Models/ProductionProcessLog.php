<?php

namespace App\Modules\Production\Models;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;





class ProductionProcessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'production_process_id',
        'operator_id',
        'supervisor_id',
        'start_time',
        'end_time',
        'notes',
    ];

    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }

    public function productionProcess()
    {
        return $this->belongsTo(ProductionProcess::class);
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id');
    }

    public function resources()
    {
        return $this->hasMany(ProcessResource::class, 'process_log_id');
    }

    public function outputs()
    {
        //return $this->hasMany(ProcessOutput::class, 'process_log_id');
    }



    public static function boot()
    {
        parent::boot();

        static::creating(function ($log) {
            //dd($log->productionProcess);
            $batchNumber = $log->batch?->batch_number ?? 'Unknown Batch';
            $processName = $log->productionProcess?->name ?? 'Unknown Process';
            $log->display_name = $batchNumber . " (" . $processName . ")";

        });

        static::saving(function ($log) {
            $batchNumber = $log->batch?->batch_number ?? 'Unknown Batch';
            $processName = $log->productionProcess?->name ?? 'Unknown Process';
            $log->display_name = $batchNumber . " (" . $processName . ")";
        });
    }




}
