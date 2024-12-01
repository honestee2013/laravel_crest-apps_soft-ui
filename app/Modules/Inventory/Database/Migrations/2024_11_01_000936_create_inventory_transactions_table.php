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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();

            $table->string('transaction_id')->unique(); // Human-readable transaction number
            $table->uuid('uuid')->unique();         // Globally unique ID

            // Transaction type linked to a new `transaction_types` table for extensibility
            $table->timestamp('transaction_date');
            $table->foreignId('transaction_type_id')->constrained('transaction_types')->onDelete('restrict');

            // Item and location relationships
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('storage_id')->constrained()->onDelete('cascade');
            //$table->foreignId('store_id')->constrained()->cascadeOnDelete();

            // Logistics and quantity
            $table->string('truck_number')->nullable();
            $table->integer('quantity');

            $table->string('reference_number')->nullable();
            $table->string('invoice')->nullable();

            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            //$table->text('description')->nullable();


            // Transaction actors
            $table->foreignId('released_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('collected_by')->nullable()->constrained('users')->onDelete('cascade');

            // Customer and Supplier relationships
            $table->foreignId('customer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('cascade');

            $table->text('note')->nullable();


            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
