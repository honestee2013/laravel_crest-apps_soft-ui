<?php

namespace App\Modules\Item\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTypesSeeder extends Seeder
{
    public function run()
    {
        $itemTypes = [
            ['display_name' => 'Raw Material', 'name' => 'raw_material', 'description' => 'Materials used in the manufacturing or production of finished goods.'],
            ['display_name' => 'Finished Good', 'name' => 'finished_good', 'description' => 'Products that are completed and ready for sale or distribution.'],
            ['display_name' => 'Semi Finished Good', 'name' => 'semi_finished_good', 'description' => 'Products that are partially finished and require further processing or assembly.'],
            ['display_name' => 'Component', 'name' => 'component', 'description' => 'Individual parts or components that are used to create finished goods or semi-finished goods.'],
            ['display_name' => 'Spare Part', 'name' => 'spare_part', 'description' => 'Parts kept in inventory to replace faulty components in machinery or finished goods.'],
            ['display_name' => 'Consumable', 'name' => 'consumable', 'description' => 'Items that are used up or consumed during business operations (e.g., office supplies, fuel, etc.).'],
            ['display_name' => 'Packaging Material', 'name' => 'packaging_material', 'description' => 'Materials used for packaging goods for storage, shipping, or sale.'],
            ['display_name' => 'Office Supplies', 'name' => 'office_supplies', 'description' => 'Items used in day-to-day office operations (e.g., paper, pens, computer accessories).'],
            ['display_name' => 'Finished Product', 'name' => 'finished_product', 'description' => 'Products that have been completed and are ready for sale or distribution to customers.'],
            ['display_name' => 'Raw Material Waste', 'name' => 'raw_material_waste', 'description' => 'Waste or by-products generated during the production of raw materials.'],
            ['display_name' => 'Product Waste', 'name' => 'product_waste', 'description' => 'Waste or by-products generated during the manufacturing or handling of finished products.'],
            ['display_name' => 'Service Item', 'name' => 'service_item', 'description' => 'Items that represent services offered (e.g., maintenance or consulting).'],
            ['display_name' => 'Liquid Material', 'name' => 'liquid_material', 'description' => 'Materials that are in liquid form (e.g., chemicals, oils, beverages).'],
            ['display_name' => 'Bulk Material', 'name' => 'bulk_material', 'description' => 'Items stored in bulk for processing, often in large quantities (e.g., grains, aggregates).'],
            ['display_name' => 'Perishable Item', 'name' => 'perishable_item', 'description' => 'Items that have a limited shelf life and require quick turnover (e.g., food, medicine).'],
            ['display_name' => 'Non Perishable Item', 'name' => 'non_perishable_item', 'description' => 'Items that have a long shelf life and can be stored for extended periods (e.g., canned goods, electronics).'],
            ['display_name' => 'Asset', 'name' => 'asset', 'description' => 'High-value items that are expected to provide long-term benefits (e.g., machinery, equipment).'],
            ['display_name' => 'Equipment', 'name' => 'equipment', 'description' => 'Tools or machines used in business operations, typically for long-term use (e.g., computers, forklifts).'],
            ['display_name' => 'Vehicle', 'name' => 'vehicle', 'description' => 'Transportation units used by the company for operations or logistics (e.g., trucks, vans, company cars).'],
            ['display_name' => 'Raw Material Inventory', 'name' => 'raw_material_inventory', 'description' => 'Inventory of raw materials used in production processes.'],
            ['display_name' => 'Finished Goods Inventory', 'name' => 'finished_goods_inventory', 'description' => 'Inventory of products that are ready for sale or distribution.'],
            ['display_name' => 'Waste Inventory', 'name' => 'waste_inventory', 'description' => 'Inventory of items that are marked as waste or unusable materials.'],
        ];

        DB::table('item_types')->insert($itemTypes);
    }
}
