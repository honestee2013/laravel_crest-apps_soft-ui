<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionStepsTable extends Migration
{
    public function up()
    {
        Schema::create('production_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id'); // Links to Batch
            $table->unsignedBigInteger('production_process_id'); // Links to Process
            $table->string('step_name'); // Optional override of process name
            $table->timestamp('started_at')->nullable(); // Step start time
            $table->timestamp('ended_at')->nullable(); // Step end time
            $table->enum('status', ['Pending', 'In Progress', 'Completed', 'Paused', 'Canceled'])->default('Pending'); // Current status
            $table->text('notes')->nullable(); // Notes or issues during the step
            $table->json('resources_consumed')->nullable(); // e.g., {"water": 100, "electricity": 50}
            $table->unsignedBigInteger('updated_by')->nullable(); // User responsible for last update
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
            $table->foreign('production_process_id')->references('id')->on('production_processes')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('production_steps');
    }
}

