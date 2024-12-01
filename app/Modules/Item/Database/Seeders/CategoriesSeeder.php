<?php

namespace App\Modules\Item\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [

            ['name' => 'raw_material', 'display_name' => 'Raw Material', 'description' => 'Materials used in the manufacturing process that are transformed into finished goods.'],
            ['name' => 'finished_goods', 'display_name' => 'Finished Goods', 'description' => 'Products that have been completed and are ready for sale or distribution.'],
            ['name' => 'semi_finished_goods', 'display_name' => 'Semi-Finished Goods', 'description' => 'Products that are partially completed and need further processing or assembly.'],
            ['name' => 'components', 'display_name' => 'Components', 'description' => 'Individual parts or components that are used to create finished or semi-finished goods.'],
            ['name' => 'packaging_material', 'display_name' => 'Packaging Materials', 'description' => 'Materials used for packaging products for storage, shipment, or sale.'],
            ['name' => 'office_supplies', 'display_name' => 'Office Supplies', 'description' => 'Items used in office operations (e.g., stationery, equipment).'],
            ['name' => 'spare_parts', 'display_name' => 'Spare Parts', 'description' => 'Parts to replace faulty components.'],
            ['name' => 'perishable_goods', 'display_name' => 'Perishable Goods', 'description' => 'Items with a limited shelf life that need to be consumed or sold quickly (e.g., food items, chemicals).'],
            ['name' => 'non_perishable_goods', 'display_name' => 'Non-Perishable Goods', 'description' => 'Items with a long shelf life (e.g., electronics, canned goods, textiles).'],
            ['name' => 'service_items', 'display_name' => 'Service Items', 'description' => 'Items related to services offered by the company (e.g., service contracts, labor hours).'],
            ['name' => 'assets', 'display_name' => 'Assets', 'description' => 'High-value items used long-term by the company (e.g., equipment, vehicles).'],
            ['name' => 'liquid_materials', 'display_name' => 'Liquid Materials', 'description' => 'Liquids or fluid-based items used in manufacturing or operations (e.g., oils, chemicals, liquids).'],
            ['name' => 'bulk_materials', 'display_name' => 'Bulk Materials', 'description' => 'Items stored in bulk, often in large quantities (e.g., grains, metals, sand).'],
            ['name' => 'assets', 'display_name' => 'Assets', 'description' => 'Long-term assets or capital goods.'],
            ['name' => 'waste_materials', 'display_name' => 'Waste Materials', 'description' => 'Waste or unusable products produced during manufacturing or business processes.'],
            ['name' => 'raw_material_waste', 'display_name' => 'Raw Material Waste', 'description' => 'Waste products from raw materials.'],
            ['name' => 'product_waste', 'display_name' => 'Product Waste', 'description' => 'Waste products generated during the manufacturing or handling of finished goods.'],

            ['display_name' => 'Materials', 'name' => 'materials', 'description' => 'Raw materials used in production.'],
            ['display_name' => 'Products', 'name' => 'products', 'description' => 'Finished and semi-finished goods.'],
            ['display_name' => 'Spare Parts', 'name' => 'spare_parts', 'description' => 'Parts to replace faulty components.'],
            ['display_name' => 'Tools', 'name' => 'tools', 'description' => 'Tools and equipment used for work or manufacturing.'],
            ['display_name' => 'Packaging', 'name' => 'packaging', 'description' => 'Materials for packaging products for storage or shipping.'],
            ['display_name' => 'Chemicals', 'name' => 'chemicals', 'description' => 'Various chemicals used for manufacturing or cleaning.'],
            ['display_name' => 'Liquid Goods', 'name' => 'liquid_goods', 'description' => 'Items in liquid form (e.g., chemicals, oils).'],
            ['display_name' => 'Electronics', 'name' => 'electronics', 'description' => 'Electronic goods and components.'],
            ['display_name' => 'Furniture', 'name' => 'furniture', 'description' => 'Furniture for office or operational use.'],
            ['display_name' => 'Transportation', 'name' => 'transportation', 'description' => 'Vehicles used for business operations (e.g., trucks, cars).'],
            ['display_name' => 'Raw Material Waste', 'name' => 'raw_material_waste', 'description' => 'Waste products from raw materials.'],
            ['display_name' => 'Finished Goods Waste', 'name' => 'finished_goods_waste', 'description' => 'Waste generated from finished goods.'],
            ['display_name' => 'Services', 'name' => 'services', 'description' => 'Items that represent services provided.'],
            ['display_name' => 'Equipment', 'name' => 'equipment', 'description' => 'Tools or machines used in business operations.'],
            ['display_name' => 'Consumables', 'name' => 'consumables', 'description' => 'Items that are consumed in daily operations.'],
            ['display_name' => 'Non Perishable', 'name' => 'non_perishable', 'description' => 'Items with a long shelf life.'],
            ['display_name' => 'Perishables', 'name' => 'perishables', 'description' => 'Items that have a limited shelf life and need quick turnover.'],


        ];

        DB::table('categories')->insert($categories);
    }
}
