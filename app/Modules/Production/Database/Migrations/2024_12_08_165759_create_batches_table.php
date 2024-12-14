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
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->string('batch_number')->unique();
            $table->foreignId('production_order_id')->nullable()->constrained('production_orders');
            //$table->string('status')->default('in-progress');

            $table->boolean('is_auto_generated')->default(true);
            $table->foreignId('status_id')->nullable()->constrained()->onDelete('set null'); // Foreign key to the units table

            $table->foreignId('created_by')->constrained('users');  // User who created the batch



            $table->timestamps();

        });






    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
