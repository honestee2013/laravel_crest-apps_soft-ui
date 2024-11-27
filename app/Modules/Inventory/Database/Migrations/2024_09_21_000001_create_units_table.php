<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
    {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();  // programmatically referenced name (snake_case)
            $table->string('symbol')->nullable(); // E.g., kg, l, pcs
            $table->string('display_name')->nullable();    // human-readable name (Title Case)
            $table->text('description')->nullable(); // Description of tag
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};

