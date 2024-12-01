<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();

            //$table->foreignId('uuid')->nullable()->constrained("inventory_transactions")->cascadeOnDelete();
            $table->string('uuid')->nullable();//->constrained("inventory_transactions")->cascadeOnDelete();
            $table->foreignId('transaction_id')->nullable()->constrained("inventory_transactions")->cascadeOnDelete();
            $table->string('adjustment_type')->nullable();
            $table->integer('adjusted_quantity')->nullable();
            $table->text('adjustment_reason')->nullable();
            $table->foreignId('adjusted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('adjustment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};
