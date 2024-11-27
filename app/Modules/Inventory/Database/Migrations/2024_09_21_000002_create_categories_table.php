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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('display_name');    // human-readable name (Title Case)
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Optional image for the category
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // For subcategories
            $table->string('status')->nullable()->default('active'); // Category status ['active', 'inactive'])
            $table->string('slug')->nullable(); // Optional for URL-friendly names
            $table->string('meta_title')->nullable(); // Optional SEO meta title
            $table->text('meta_description')->nullable(); // Optional SEO meta description
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
        Schema::dropIfExists('categories');
    }
};
