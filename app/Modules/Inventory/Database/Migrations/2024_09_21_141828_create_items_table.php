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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('set null'); // Foreign key to the units table
            //$table->foreignId('tag_id')->nullable()->constrained('tags')->onDelete('set null'); // Foreign key to the units table
            $table->string('sku')->nullable()->unique(); // Stock Keeping Unit
            $table->decimal('selling_price', 10, 2)->default(00.00); // e.g., 9999.99
            $table->string('item_type')->nullable();//, ['resource', 'finished_good'])->default('finished_good'); // Type of item
            $table->string('image')->nullable(); // Path to the image
            $table->string('status')->nullable();//, ['available', 'discontinued', 'out_of_stock'])->default('available');
            $table->decimal('weight', 8, 2)->nullable(); // Optional for physical items
            $table->string('dimensions')->nullable(); // Optional for physical items (e.g., 10x10x10 cm)
            $table->string('barcode')->nullable(); // Optional barcode
            $table->decimal('cost_price', 10, 2)->nullable(); // Cost price for profit calculations
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
        Schema::dropIfExists('items');
    }
};

