<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
    {
    public function up()
    {
        Schema::create('storage_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // programmatically referenced name (snake_case)
            $table->string('display_name');    // human-readable name (Title Case)
            $table->text('description')->nullable(); // Description of storage type
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('storage_types');
    }
};



