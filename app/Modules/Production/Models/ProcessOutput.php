<?php
namespace App\Modules\Production\Models;

use App\Modules\Item\Models\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class ProcessOutput extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_process_log_id',
        'item_id',
        'quantity_produced',
    ];

    public function ProductionProcessLog()
    {
        return $this->belongsTo(ProductionProcessLog::class, 'production_process_log_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }







}
