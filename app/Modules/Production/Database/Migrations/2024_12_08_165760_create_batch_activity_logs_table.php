<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchActivityLogsTable extends Migration
{
    public function up()
    {
        Schema::create('batch_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('batch_id'); // Links to Batch
            $table->timestamp('activity_time'); // When the activity occurred
            $table->string('activity_type'); // e.g., 'Status Change', 'Pause', 'Resume'
            $table->text('description')->nullable(); // Detailed description of the activity
            $table->unsignedBigInteger('performed_by')->nullable(); // User who performed the action
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('batch_activity_logs');
    }
}
