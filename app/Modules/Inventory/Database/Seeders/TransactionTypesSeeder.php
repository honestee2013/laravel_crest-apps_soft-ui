<?php

namespace App\Modules\Inventory\Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class TransactionTypesSeeder extends Seeder
{
    public function run()
    {
        $transactionTypes = [
                ['storage_direction' => 'IN', 'name' => 'purchase', 'display_name' => 'Purchase', 'description' => 'Items bought from a supplier.'],
                ['storage_direction' => 'OUT', 'name' => 'sales', 'display_name' => 'Sales', 'description' => 'Items sold to a customer.'],
                ['storage_direction' => 'IN', 'name' => 'return_in', 'display_name' => 'Return In', 'description' => 'Items returned from customers.'],
                ['storage_direction' => 'OUT', 'name' => 'return_out', 'display_name' => 'Return Out', 'description' => 'Items returned to suppliers.'],
                ['storage_direction' => 'IN', 'name' => 'transfer_in', 'display_name' => 'Transfer In', 'description' => 'Items transferred into a storage or location.'],
                ['storage_direction' => 'OUT', 'name' => 'transfer_out', 'display_name' => 'Transfer Out', 'description' => 'Items transferred out to another storage or location.'],
                ['storage_direction' => 'IN', 'name' => 'adjustment_in', 'display_name' => 'Adjustment In', 'description' => 'Positive stock adjustments (e.g., stock corrections).'],
                ['storage_direction' => 'OUT', 'name' => 'adjustment_out', 'display_name' => 'Adjustment Out', 'description' => 'Negative stock adjustments (e.g., damages).'],
                ['storage_direction' => 'IN', 'name' => 'production_in', 'display_name' => 'Production In', 'description' => 'Finished goods added after production.'],
                ['storage_direction' => 'OUT', 'name' => 'production_out', 'display_name' => 'Production Out', 'description' => 'Raw materials consumed during production.'],
                ['storage_direction' => 'OUT', 'name' => 'waste', 'display_name' => 'Waste', 'description' => 'Items marked as waste or unusable.'],
                ['storage_direction' => 'OUT', 'name' => 'damage', 'display_name' => 'Damage', 'description' => 'Items damaged during handling or storage.'],
                ['storage_direction' => 'OUT', 'name' => 'scrap', 'display_name' => 'Scrap', 'description' => 'Scrap materials recorded for disposal or recycling.'],
                ['storage_direction' => 'OUT', 'name' => 'consumption', 'display_name' => 'Consumption', 'description' => 'Items consumed internally (e.g., office supplies).'],
                ['storage_direction' => 'OUT', 'name' => 'donation', 'display_name' => 'Donation', 'description' => 'Items donated to an organization or individual.'],
                ['storage_direction' => 'OUT', 'name' => 'loan', 'display_name' => 'Loan', 'description' => 'Items loaned out temporarily.'],
                ['storage_direction' => 'IN', 'name' => 'loan_return', 'display_name' => 'Loan Return', 'description' => 'Items returned from a loan.'],
                ['storage_direction' => 'OUT', 'name' => 'sample_out', 'display_name' => 'Sample Out', 'description' => 'Items sent out as samples.'],
                ['storage_direction' => 'IN', 'name' => 'sample_return', 'display_name' => 'Sample Return', 'description' => 'Samples returned from customers.'],
                ['storage_direction' => 'OUT', 'name' => 'trial_use', 'display_name' => 'Trial Use', 'description' => 'Items issued for trial or testing purposes.'],
                ['storage_direction' => 'IN', 'name' => 'trial_return', 'display_name' => 'Trial Return', 'description' => 'Items returned after a trial or test.'],

        ];

        // Insert data into the database
        DB::table('transaction_types')->insert($transactionTypes);
    }

}
