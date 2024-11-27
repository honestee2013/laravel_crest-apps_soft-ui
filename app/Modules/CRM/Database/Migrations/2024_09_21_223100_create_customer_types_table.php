<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
    public function up()
    {
        Schema::create('customer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Snake_case name for programmatic use
            $table->string('display_name'); // Descriptive name for user-friendly display
            $table->text('description')->nullable(); // Optional description
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_types');
    }
};
