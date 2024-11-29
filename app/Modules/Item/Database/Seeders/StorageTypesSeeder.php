<?php

namespace App\Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageTypesSeeder extends Seeder
{
    public function run()
    {
        $storageTypes = [
            ['name' => 'warehouse', 'display_name' => 'Warehouse', 'description' => 'A large centralized facility used for storing goods and inventory for long-term use or distribution.'],
            ['name' => 'store_room', 'display_name' => 'Store Room', 'description' => 'A smaller space within an office or facility used for storing supplies and items temporarily.'],
            ['name' => 'cold_storage', 'display_name' => 'Cold Storage', 'description' => 'Temperature-controlled storage for perishable goods such as food, medicine, and chemicals.'],
            ['name' => 'outdoor_storage', 'display_name' => 'Outdoor Storage', 'description' => 'Open storage areas for items that can withstand weather conditions, such as construction materials or machinery.'],
            ['name' => 'silo', 'display_name' => 'Silo', 'description' => 'Tall, cylindrical storage structures used for bulk storage of grains, feed, or other loose materials.'],
            ['name' => 'tank', 'display_name' => 'Tank', 'description' => 'Storage containers used for liquids or gases, such as fuel, water, or chemicals.'],
            ['name' => 'shelf', 'display_name' => 'Shelf', 'description' => 'Racks or shelves for smaller, organized storage of lightweight items.'],
            ['name' => 'locker', 'display_name' => 'Locker', 'description' => 'Individual secure storage units for personal or specific-use items.'],
            ['name' => 'bin', 'display_name' => 'Bin', 'description' => 'Small containers or boxes for organizing and storing smaller items or loose components.'],
            ['name' => 'refrigerator', 'display_name' => 'Refrigerator', 'description' => 'Small-scale cold storage for perishable items, often used in retail or office settings.'],
            ['name' => 'freezer', 'display_name' => 'Freezer', 'description' => 'Ultra-low temperature storage for frozen goods and products.'],
            ['name' => 'mobile_storage', 'display_name' => 'Mobile Storage', 'description' => 'Portable storage units used for temporary or on-the-move storage needs.'],
            ['name' => 'container', 'display_name' => 'Container', 'description' => 'Shipping containers used for transporting and storing goods, often in logistics and trade.'],
            ['name' => 'rack', 'display_name' => 'Rack', 'description' => 'Tiered storage used in warehouses to store pallets or other heavy items.'],
            ['name' => 'vault', 'display_name' => 'Vault', 'description' => 'Highly secure storage for valuable items such as money, jewelry, or sensitive documents.'],
            ['name' => 'quarantine_area', 'display_name' => 'Quarantine Area', 'description' => 'Designated storage for goods awaiting inspection, quality control, or clearance.'],
            ['name' => 'bulk_storage_area', 'display_name' => 'Bulk Storage Area', 'description' => 'Open or enclosed space for storing bulk materials such as grains, minerals, or aggregates.'],
            ['name' => 'automated_storage', 'display_name' => 'Automated Storage', 'description' => 'High-tech storage systems controlled by robotics or automated processes for efficiency.'],
            ['name' => 'hazardous_material_storage', 'display_name' => 'Hazardous Material Storage', 'description' => 'Specialized storage for hazardous items such as chemicals, flammable goods, or radioactive materials.'],
            ['name' => 'showroom', 'display_name' => 'Showroom', 'description' => 'Storage and display area for items intended for retail or client presentations.'],
            ['name' => 'receiving_area', 'display_name' => 'Receiving Area', 'description' => 'Temporary storage for goods immediately after delivery, awaiting processing or inspection.'],
            ['name' => 'dispatch_area', 'display_name' => 'Dispatch Area', 'description' => 'Storage for items prepared for outgoing shipments or deliveries.'],
        ];

        DB::table('storage_types')->insert($storageTypes);
    }
}
