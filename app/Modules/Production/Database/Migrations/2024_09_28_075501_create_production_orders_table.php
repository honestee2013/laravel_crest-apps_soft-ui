<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionOrdersTable extends Migration
{
    public function up()
{
    Schema::create('production_orders', function (Blueprint $table) {
        $table->id();
        $table->string('name')->nullable();
        $table->text('description')->nullable();

        // 'order_time' can be removed if you use Laravel's 'created_at'
        $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade'); // User who created the order
        $table->foreignId('supervisor_id')->nullable()->constrained('users')->onDelete('set null'); // Supervisor/manager
        $table->string('batch_number')->unique(); // Unique batch number

        $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null'); // Department responsible

        $table->dateTime('expected_start_time')->nullable(); // Start of production
        $table->dateTime('expected_end_time')->nullable(); // Expected end of production
        $table->dateTime('completed_at')->nullable(); // Actual end of production (optional)

        $table->enum('status', ['pending', 'in_progress', 'completed', 'canceled'])->default('pending'); // Order status

        //$table->decimal('planned_quantity', 10, 2)->nullable(); // Planned production quantity
        //$table->decimal('actual_quantity', 10, 2)->nullable(); // Actual produced quantity (optional)

        $table->text('notes')->nullable(); // Optional notes
        $table->timestamps(); // Adds 'created_at' and 'updated_at'
    });
}



    public function down()
    {
        Schema::dropIfExists('production_orders');
    }
}
