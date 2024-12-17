<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('batch_trackers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->nullable()->constrained('production_batches');
            $table->string('status')->nullable(); // e.g., Pending, In Progress, Completed
            $table->timestamp('last_updated_at')->nullable(); // Tracks the last activity time
            $table->text('remarks')->nullable(); // Notes or summary about the batch
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batch_trackers');
    }
};
