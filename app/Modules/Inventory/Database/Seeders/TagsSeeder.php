<?php

namespace App\Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            ['display_name' => 'High Priority', 'name' => 'high_priority', 'description' => 'Items that are high priority and need fast processing or usage.'],
            ['display_name' => 'Sale', 'name' => 'sale', 'description' => 'Items that are on sale or promotional items.'],
            ['display_name' => 'Exclusive', 'name' => 'exclusive', 'description' => 'Items that are limited edition or exclusive.'],
            ['display_name' => 'Custom', 'name' => 'custom', 'description' => 'Items that are customized or made-to-order.'],
            ['display_name' => 'Obsolete', 'name' => 'obsolete', 'description' => 'Items that are no longer in use or outdated.'],
            ['display_name' => 'Refurbished', 'name' => 'refurbished', 'description' => 'Items that have been restored or repaired to be reused.'],
            ['display_name' => 'Luxury', 'name' => 'luxury', 'description' => 'High-end or premium items.'],
            ['display_name' => 'Non Stock', 'name' => 'non_stock', 'description' => 'Items that are not regularly stocked.'],
            ['display_name' => 'Out Of Stock', 'name' => 'out_of_stock', 'description' => 'Items that have finished inside the store'],
            ['display_name' => 'Discontinued', 'name' => 'discontinued', 'description' => 'Items that are no longer being produced or sold.'],


            ['name' => 'fragile', 'display_name' => 'Fragile', 'description' => 'Items that are easily damaged and require careful handling.'],
            ['name' => 'hazardous', 'display_name' => 'Hazardous', 'description' => 'Items that are dangerous or harmful (e.g., chemicals, explosives).'],
            ['name' => 'flammable', 'display_name' => 'Flammable', 'description' => 'Items that can catch fire easily (e.g., petrol, certain chemicals).'],
            ['name' => 'perishable', 'display_name' => 'Perishable', 'description' => 'Items that have a limited shelf life and need quick turnover (e.g., food, pharmaceuticals).'],
            ['name' => 'bulk', 'display_name' => 'Bulk', 'description' => 'Items that are stored or purchased in large quantities (e.g., bulk grains, liquids).'],
            ['name' => 'imported', 'display_name' => 'Imported', 'description' => 'Items that are brought from outside the country.'],
            ['name' => 'domestic', 'display_name' => 'Domestic', 'description' => 'Items that are produced within the country.'],
            ['name' => 'eco_friendly', 'display_name' => 'Eco-Friendly', 'description' => 'Items that are environmentally friendly or sustainable (e.g., recyclable materials, biodegradable items).'],
            ['name' => 'high_demand', 'display_name' => 'High Demand', 'description' => 'Items that are in frequent or continuous demand in the market.'],
            ['name' => 'low_stock', 'display_name' => 'Low Stock', 'description' => 'Items that are currently in low stock and need restocking.'],
            ['name' => 'out_of_stock', 'display_name' => 'Out of Stock', 'description' => 'Items that are currently out of inventory.'],
            ['name' => 'new_arrival', 'display_name' => 'New Arrival', 'description' => 'New items that have recently arrived or been added to inventory.'],
            ['name' => 'premium', 'display_name' => 'Premium', 'description' => 'High-quality or exclusive items in inventory, usually at a higher price point.'],
            ['name' => 'clearance', 'display_name' => 'Clearance', 'description' => 'Items that are on sale for clearance or to reduce inventory.'],
            ['name' => 'seasonal', 'display_name' => 'Seasonal', 'description' => 'Items that are typically in demand during certain seasons or holidays (e.g., Christmas decorations, winter clothes).'],


        ];

        DB::table('tags')->insert($tags);
    }
}
