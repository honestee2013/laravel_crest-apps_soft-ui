<?php

namespace App\Modules\Procurement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierTypesSeeder extends Seeder
{
    public function run()
    {
        $supplierTypes = [
            ['name' => 'raw_material_supplier', 'display_name' => 'Raw Material Supplier', 'description' => 'Supplies raw materials used in manufacturing or production.'],
            ['name' => 'equipment_supplier', 'display_name' => 'Equipment Supplier', 'description' => 'Provides machinery, tools, or equipment.'],
            ['name' => 'service_provider', 'display_name' => 'Service Provider', 'description' => 'Offers services such as maintenance or consulting.'],
            ['name' => 'distributor', 'display_name' => 'Distributor', 'description' => 'Distributes goods on behalf of manufacturers to retailers or customers.'],
            ['name' => 'manufacturer', 'display_name' => 'Manufacturer', 'description' => 'Produces goods or products from raw materials.'],
            ['name' => 'local _supplier', 'display_name' => 'Local Supplier', 'description' => 'Operates and supplies goods within a specific local region.'],
            ['name' => 'international_supplier', 'display_name' => 'International Supplier', 'description' => 'Supplies goods across international borders.'],
            ['name' => 'wholesale_supplier', 'display_name' => 'Wholesale Supplier', 'description' => 'Provides goods in large quantities to retailers or resellers.'],
            ['name' => 'retail_supplier', 'display_name' => 'Retail Supplier', 'description' => 'Sells goods directly to consumers in small quantities.'],
            ['name' => 'contract_supplier', 'display_name' => 'Contract Supplier', 'description' => 'Supplies goods or services based on a contractual agreement.'],
        ];

        DB::table('supplier_types')->insert($supplierTypes);
    }
}
