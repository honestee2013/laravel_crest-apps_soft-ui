<?php

namespace App\Modules\Inventory\Models;

use App\Models\User;
use App\Modules\Item\Models\Item;
use App\Modules\CRM\Models\Customer;

use App\Modules\Storage\Models\Storage;
use Illuminate\Database\Eloquent\Model;

use App\Modules\Procurement\Models\Supplier;
use App\Modules\Core\Services\ReadableIdGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class InventoryTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_date',
        'transaction_type_id',
        'storage_direction',

        'item_id',
        'storage_id',

        'truck_number',
        'quantity',

        'reference_number',
        'invoice',

        'note',
        'recorded_by',

        'released_by',
        'collected_by',

        'customer_id',
        'supplier_id',
        'transaction_id',
        'uuid',
    ];







    /**
     * Boot method to generate UUID and readable ID on creation.
     */
    protected static function booted()
    {
        static::creating(function ($transaction) {
            $transaction->uuid = ReadableIdGenerator::generateUuid();

            // Ensure transactionType relationship exists and has a 'name' property
            $type = $transaction->transactionType->name ?? 'General'; // Default to 'GEN' if not found

            // Truncate based on configured length (default to 3)
            $truncateLength = 3;// config('app.transaction_type_length', 3);
            $type = substr($type, 0, $truncateLength);

            $transaction->transaction_id = ReadableIdGenerator::generate(strtoupper($type), self::class);
        });


    }


        /**
     * Generate a readable ID based on type, date, and sequence.
     */
    private static function generateReadableId(string $type): string
    {
        $year = now()->year;
        $month = now()->format('m');
        $count = self::where('transaction_type', $type)
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        return strtoupper($type) . "-$year-$month-" . str_pad($count, 6, '0', STR_PAD_LEFT);
    }




    public function item()
    {
        return $this->belongsTo(Item::class);
    }


    public function storage()
    {
        return $this->belongsTo(Storage::class);
    }


    public function getStorageLocationAttribute($value) {
//dd($this->storage->location->address);
        return $this->storage->location->name.", ".$this->storage->location->address;

    }



    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function transactionType()
    {
        return $this->belongsTo(TransactionType::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }



    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }


    public function releasedBy()
    {
        return $this->belongsTo(User::class, 'released_by', 'id');
    }



    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'collected_by', 'id');
    }






}
