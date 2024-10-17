<?php

namespace app\Modules\Core\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Core\Livewire\DataTables\DataTable;

class DataTableTest extends TestCase
{


    /** @test */
    public function test_data_table_request_respose_success()
    {
        $response = $this->get('/testing'); // Adjust this path to match your route
        $response->assertStatus(200);
    }


    public function test_data_table_sort_success()
    {
        $response = $this->get('/testing'); // Adjust this path to match your route
        $response->assertStatus(200);
    }




}
