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
        Schema::create('storage_limits', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('storage_id')->constrained('storages')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onDelete('cascade');

            $table->integer('item_limit'); // Limit per item per storage location
            $table->timestamps();

            // Unique index to enforce unique storage-item pairs
            $table->unique(['storage_id', 'item_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_limits');
    }
};
