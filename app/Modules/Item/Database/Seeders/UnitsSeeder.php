<?php

namespace App\Modules\Item\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsSeeder extends Seeder
{
    public function run()
    {
        $units = [
            ['display_name' => 'Kilogram', 'name' => 'kilogram', 'symbol' => 'kg', 'description' => 'A metric unit of mass.'],
            ['display_name' => 'Gram', 'name' => 'gram', 'symbol' => 'g', 'description' => 'A metric unit of mass, equal to one thousandth of a kilogram.'],
            ['display_name' => 'Ton', 'name' => 'ton', 'symbol' => 't', 'description' => 'A unit of mass equal to 1,000 kilograms.'],
            ['display_name' => 'Liter', 'name' => 'liter', 'symbol' => 'l', 'description' => 'A metric unit of volume.'],
            ['display_name' => 'Milliliter', 'name' => 'milliliter', 'symbol' => 'ml', 'description' => 'A metric unit of volume, equal to one thousandth of a liter.'],
            ['display_name' => 'Meter', 'name' => 'meter', 'symbol' => 'm', 'description' => 'A metric unit of length or distance.'],
            ['display_name' => 'Centimeter', 'name' => 'centimeter', 'symbol' => 'cm', 'description' => 'A metric unit of length, equal to one hundredth of a meter.'],
            ['display_name' => 'Millimeter', 'name' => 'millimeter', 'symbol' => 'mm', 'description' => 'A metric unit of length, equal to one thousandth of a meter.'],
            ['display_name' => 'Square Meter', 'name' => 'square_meter', 'symbol' => 'm²', 'description' => 'A unit of area, equal to the area of a square with sides one meter in length.'],
            ['display_name' => 'Cubic Meter', 'name' => 'cubic_meter', 'symbol' => 'm³', 'description' => 'A unit of volume, equal to the volume of a cube with sides one meter in length.'],
            ['display_name' => 'Kilometer', 'name' => 'kilometer', 'symbol' => 'km', 'description' => 'A unit of length or distance, equal to 1,000 meters.'],
            ['display_name' => 'Yard', 'name' => 'yard', 'symbol' => 'yd', 'description' => 'A unit of length, equal to 3 feet or 0.9144 meters.'],
            ['display_name' => 'Foot', 'name' => 'foot', 'symbol' => 'ft', 'description' => 'A unit of length, equal to 12 inches or 0.3048 meters.'],
            ['display_name' => 'Inch', 'name' => 'inch', 'symbol' => 'in', 'description' => 'A unit of length, equal to 1/12 of a foot or 2.54 cm.'],
            ['display_name' => 'Mile', 'name' => 'mile', 'symbol' => 'mi', 'description' => 'A unit of length, equal to 1,609.34 meters.'],
            ['display_name' => 'Liter Per 100km', 'name' => 'liter_per_100km', 'symbol' => 'l/100km', 'description' => 'A unit of fuel consumption (liters per 100 kilometers).'],
            ['display_name' => 'Piece', 'name' => 'piece', 'symbol' => 'pc', 'description' => 'A single individual item or unit, used for discrete items such as products, parts, etc.'],
            ['display_name' => 'Box', 'name' => 'box', 'symbol' => 'bx', 'description' => 'A container used for packing items, often a collection of individual pieces or items.'],
            ['display_name' => 'Pack', 'name' => 'pack', 'symbol' => 'pk', 'description' => 'A smaller container or grouping of items.'],
            ['display_name' => 'Dozen', 'name' => 'dozen', 'symbol' => 'dz', 'description' => 'A unit of quantity, equal to 12 items.'],
            ['display_name' => 'Gross', 'name' => 'gross', 'symbol' => 'grs', 'description' => 'A unit of quantity, equal to 144 items (12 dozen).'],
            ['display_name' => 'Pair', 'name' => 'pair', 'symbol' => 'pr', 'description' => 'A unit for items that come in pairs (e.g., shoes, gloves).'],
            ['display_name' => 'Set', 'name' => 'set', 'symbol' => 'st', 'description' => 'A group or collection of items that are sold or stored together.'],
            ['display_name' => 'Bag', 'name' => 'bag', 'symbol' => 'bg', 'description' => 'A unit of packaging, typically used for bulk goods like grains or sand.'],
            ['display_name' => 'Pound', 'name' => 'pound', 'symbol' => 'lb', 'description' => 'A unit of weight, equal to 16 ounces or 0.453592 kilograms.'],
            ['display_name' => 'Ounce', 'name' => 'ounce', 'symbol' => 'oz', 'description' => 'A unit of weight, equal to 1/16 of a pound or 28.3495 grams.'],
            ['display_name' => 'Barrel', 'name' => 'barrel', 'symbol' => 'bbl', 'description' => 'A unit of volume, often used for liquids like oil, equal to 42 gallons (158.987 liters).'],
            ['display_name' => 'Gallon', 'name' => 'gallon', 'symbol' => 'gal', 'description' => 'A unit of volume, equal to 3.78541 liters.'],
            ['display_name' => 'Quart', 'name' => 'quart', 'symbol' => 'qt', 'description' => 'A unit of volume, equal to one-fourth of a gallon or 0.946352 liters.'],
            ['display_name' => 'Pint', 'name' => 'pint', 'symbol' => 'pt', 'description' => 'A unit of volume, equal to one-half of a quart or 0.473176 liters.'],
            ['display_name' => 'Cup', 'name' => 'cup', 'symbol' => 'cup', 'description' => 'A unit of volume used in cooking, often equal to 8 fluid ounces or 0.236588 liters.'],
            ['display_name' => 'Teaspoon', 'name' => 'teaspoon', 'symbol' => 'tsp', 'description' => 'A unit of volume, equal to 1/3 of a tablespoon or about 4.9 milliliters.'],
            ['display_name' => 'Tablespoon', 'name' => 'tablespoon', 'symbol' => 'tbsp', 'description' => 'A unit of volume, equal to 3 teaspoons or about 14.8 milliliters.'],
            ['display_name' => 'Kilowatt Hour', 'name' => 'kilowatt_hour', 'symbol' => 'kWh', 'description' => 'A unit of energy, commonly used to measure electricity consumption.'],
            ['display_name' => 'Megawatt', 'name' => 'megawatt', 'symbol' => 'MW', 'description' => 'A unit of power, equal to one million watts.'],
            ['display_name' => 'Watt', 'name' => 'watt', 'symbol' => 'W', 'description' => 'A unit of power, equal to one joule per second.'],
            ['display_name' => 'Cubic Centimeter', 'name' => 'cubic_centimeter', 'symbol' => 'cm³', 'description' => 'A unit of volume, equal to the volume of a cube with sides one centimeter in length.'],
            ['display_name' => 'Cubic Inch', 'name' => 'cubic_inch', 'symbol' => 'in³', 'description' => 'A unit of volume, equal to the volume of a cube with sides one inch in length.'],
            ['display_name' => 'Square Centimeter', 'name' => 'square_centimeter', 'symbol' => 'cm²', 'description' => 'A unit of area, equal to the area of a square with sides one centimeter in length.'],
            ['display_name' => 'Square Inch', 'name' => 'square_inch', 'symbol' => 'in²', 'description' => 'A unit of area, equal to the area of a square with sides one inch in length.'],
            ['display_name' => 'Millisecond', 'name' => 'millisecond', 'symbol' => 'ms', 'description' => 'A unit of time, equal to one thousandth of a second.'],
            ['display_name' => 'Second', 'name' => 'second', 'symbol' => 's', 'description' => 'The base unit of time in the International System of Units (SI).'],
            ['display_name' => 'Minute', 'name' => 'minute', 'symbol' => 'min', 'description' => 'A unit of time, equal to 60 seconds.'],
            ['display_name' => 'Hour', 'name' => 'hour', 'symbol' => 'hr', 'description' => 'A unit of time, equal to 60 minutes.'],
        ];

        DB::table('units')->insert($units);
    }
}
