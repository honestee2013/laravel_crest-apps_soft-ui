<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string( 'logo')->nullable();
            $table->string( 'name')->nullable();;
            $table->foreignId('location_id')->nullable()->constrained()->onDelete('cascade');
            //$table->foreignId('country')->constrained()->onDelete('cascade');
            //$table->foreignId('state')->constrained()->onDelete('cascade');
            //$table->foreignId('city')->constrained()->onDelete('cascade');

            $table->string( 'phone')->nullable();
            $table->string( 'email')->nullable();;
            $table->string( 'website')->nullable();;
            $table->string( 'address')->nullable();;
            $table->string( 'postal_code')->nullable();;

            $table->string('status')->nullable();// ['active', 'inactive', 'dissolved'])->default('active');

            $table->text( 'description')->nullable();;
            $table->date('date_established')->nullable();;
            // Add other columns as needed
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
        Schema::dropIfExists('companies');
    }
}
