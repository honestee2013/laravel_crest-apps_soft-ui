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


            $table->string('name')->unique();  // programmatically referenced name (snake_case)
            //$table->string('display_name')->nullable();    // human-readable name (Title Case)


            $table->text('description')->nullable();
            $table->foreignId( 'location_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId( 'storage_type_id')->nullable()->constrained()->onDelete('set null');


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



