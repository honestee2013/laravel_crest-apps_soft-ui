<?php

namespace App\Modules\CRM\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerTypesSeeder extends Seeder
{
    public function run()
    {
        $customerTypes = [
            ['name' => 'individual', 'display_name' => 'Individual', 'description' => 'A single person purchasing for personal use.'],
            ['name' => 'corporate', 'display_name' => 'Corporate', 'description' => 'A business entity or organization as a customer.'],
            ['name' => 'retail', 'display_name' => 'Retail', 'description' => 'A customer purchasing in small quantities for resale.'],
            ['name' => 'wholesale', 'display_name' => 'Wholesale', 'description' => 'A customer buying in bulk for resale purposes.'],
            ['name' => 'distributor', 'display_name' => 'Distributor', 'description' => 'An intermediary that resells goods to retailers or businesses.'],
            ['name' => 'reseller', 'display_name' => 'Reseller', 'description' => 'A business or individual that resells goods purchased from suppliers.'],
            ['name' => 'government', 'display_name' => 'Government', 'description' => 'A government body or agency as the customer.'],
            ['name' => 'nonprofit_organization', 'display_name' => 'Nonprofit Organization', 'description' => 'An organization purchasing for charitable purposes.'],
            ['name' => 'vip_customer', 'display_name' => 'VIP Customer', 'description' => 'A high-value customer given priority services.'],
            ['name' => 'new_customer', 'display_name' => 'New Customer', 'description' => 'A first-time customer engaging with the business.'],
        ];

        DB::table('customer_types')->insert($customerTypes);
    }
}
