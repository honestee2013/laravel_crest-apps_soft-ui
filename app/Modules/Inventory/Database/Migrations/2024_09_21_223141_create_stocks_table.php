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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('released_by')->constrained('users')->onDelete('cascade'); // Assuming 'released_by' and 'collected_by' refer to the 'users' table
            $table->foreignId(column: 'collected_by')->constrained('users')->onDelete('cascade'); // Make sure to specify the table name if it's not 'collected_by'

            $table->foreignId(column: 'customer_id')->constrained()->onDelete('cascade');
            $table->foreignId(column: 'supplier_id')->constrained()->onDelete('cascade');

            $table->string(column: 'truck_number')->nullable();

            //$table->foreignId('batch_id')->constrained('batches')->onDelete('cascade');

            $table->enum('type', ['in', 'out']); // To indicate whether it's stock in or out
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
