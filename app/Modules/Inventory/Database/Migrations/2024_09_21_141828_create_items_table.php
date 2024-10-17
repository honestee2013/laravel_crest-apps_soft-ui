<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
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
            $table->foreignId('unit_id')->nullable()->constrained('units')->onDelete('cascade'); // Foreign key to the units table
            $table->string('sku')->nullable()->unique(); // Stock Keeping Unit
            $table->decimal('price', 10, 2)->default(00.00); // e.g., 9999.99
            $table->enum('item_type', ['resource', 'finished_good'])->default('finished_good'); // Type of item
            $table->string('image')->nullable(); // Path to the image
            $table->enum('status', ['available', 'discontinued', 'out_of_stock'])->default('available');
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
}

