<?php

namespace App\Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['name' => 'pending', 'display_name' => 'Pending', 'description' => 'Waiting for approval or further processing.'],
            ['name' => 'approved', 'display_name' => 'Approved', 'description' => 'Has been reviewed and authorized.'],
            ['name' => 'rejected', 'display_name' => 'Rejected', 'description' => 'Not approved and marked for denial.'],
            ['name' => 'completed', 'display_name' => 'Completed', 'description' => 'Fully processed and finished.'],
            ['name' => 'canceled', 'display_name' => 'Canceled', 'description' => 'Stopped or terminated before completion.'],
            ['name' => 'returned', 'display_name' => 'Returned', 'description' => 'Sent back to the original source.'],
            ['name' => 'on_hold', 'display_name' => 'On Hold', 'description' => 'Temporarily paused for some reason.'],
            ['name' => 'in_progress', 'display_name' => 'In Progress', 'description' => 'Currently being worked on.'],
            ['name' => 'under_review', 'display_name' => 'Under Review', 'description' => 'Being examined or evaluated.'],
            ['name' => 'scheduled', 'display_name' => 'Scheduled', 'description' => 'Planned for future action or execution.'],
        ];

        DB::table('statuses')->insert($statuses);
    }
}
