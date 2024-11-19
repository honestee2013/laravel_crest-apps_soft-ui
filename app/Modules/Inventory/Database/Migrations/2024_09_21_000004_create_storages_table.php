<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
    {
    public function up()
    {
        Schema::create('storages', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->foreignId( 'location_id')->nullable()->constrained()->onDelete('cascade');

            $table->string('storage_type')->nullable(); // ['store', 'warehouse']); // or you could use a string if more types are anticipated

            $table->string('opening_hours')->nullable();
            $table->string('closing_hours')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('storages');
    }
};



