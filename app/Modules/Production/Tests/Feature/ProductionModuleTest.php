<?php

namespace app\Modules\Production\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Core\Livewire\DataTables\DataTable;

class ProductionModuleTest extends TestCase
{
    //use RefreshDatabase; // Resets database between tests to ensure isolation

    /*public function test_successful_http_resquest_and_response() {
        // Simulate a request to the data table route
        $response = $this->get('/testing'); // Adjust this path to match your route

        // Assert that the response is successful (HTTP status 200)
        $response->assertStatus(200);
    }*/



    /** @test */
    public function test_production_order_request_respose_success()
    {
        // Simulate a request to the data table route
        $response = $this->get('/production/production-order'); // Adjust this path to match your route

        // Assert that the response is successful (HTTP status 200)
        $response->assertStatus(200);
      }






}
