<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('production_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('activity'); // E.g., Batch created, Process started
            $table->text('details')->nullable();
            $table->timestamp('timestamp');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('production_logs');
    }
};
