<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
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
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable(); // Optional image for the category
            $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade'); // For subcategories
            $table->enum('status', ['active', 'inactive'])->default('active'); // Category status
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
}
