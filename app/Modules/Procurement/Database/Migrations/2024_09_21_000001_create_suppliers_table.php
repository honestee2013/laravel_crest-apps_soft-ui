<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Supplier account (login credentials)
            $table->foreignId('managed_by')->nullable()->constrained('users')->onDelete('set null'); // Internal user managing this supplier
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // User who created this supplier record (Audit Trail)
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null'); // User who last updated this supplier record (Audit Trail)

            //$table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            //$table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');


            $table->string('supplier_type')->default('general'); // Type of supplier (e.g., raw_material, finished_product, spare_parts)
            $table->text('notes')->nullable(); // Additional notes about the supplier

            $table->string('company_name')->nullable(); // Supplier company name
            $table->string('zip_code')->nullable(); // Zip/Postal Code
            $table->string('website')->nullable(); // Supplier website
            $table->string('supplier_tag')->default('wholesale'); // Supplier type (wholesale/retail/others)
            $table->string('status')->default('active'); // Active status

            //$table->string('name'); // Supplier name
            //$table->string('contact_person')->nullable(); // Contact person
            //$table->string('phone')->nullable(); // Phone number of the supplier
            //$table->string('email')->nullable(); // Email address
            //$table->string('address')->nullable(); // Supplier address
            //$table->string('city')->nullable(); // City
            //$table->string('state')->nullable(); // State/Region
            //$table->string('country')->nullable(); // Country

            $table->timestamps(); // Created at, Updated at timestamps

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
