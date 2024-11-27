<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable(); // Customer image
            $table->string('name')->nullable(); // Customer name
            $table->string('email')->nullable()->unique(); // Email (optional, can be used for login/communication)
            $table->string('phone')->nullable(); // Phone number
            $table->string('address')->nullable(); // Customer address
            $table->string('city')->nullable(); // City
            $table->string('state')->nullable(); // State/Region
            $table->string('country')->nullable(); // Country
            $table->string('zip_code')->nullable(); // Zip/Postal Code
            $table->string('contact_person')->nullable(); // Contact person for the customer
            $table->foreignId('customer_type_id')->nullable()->constrained()->onDelete('set null'); // Can be linked to user for login
            $table->text('notes')->nullable(); // Additional notes or information

            $table->timestamp('date_of_birth')->nullable(); // For individual customers
            $table->timestamp('registered_at')->useCurrent(); // When customer was registered
            $table->string('status')->default('active'); // Active status

            //$table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Can be linked to user for login
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
