<?php

namespace app\Modules\Core\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Core\Livewire\DataTables\DataTable;
use App\Modules\Core\Livewire\DataTables\DataTableControl;
use App\Modules\Core\Livewire\DataTables\DataTableManager;
use App\Modules\Core\Traits\DataTable\DataTableControlsTrait;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;

class EnterpriseModuleTest extends TestCase
{

    //use DataTableFieldsConfigTrait, DataTableControlsTrait;

    /** @test */
    public function test_enterprise_locations_page_loaded_successfully()
    {
        $response = $this->get('/enterprise/locations');
        $response->assertStatus(200);

    }

    public function test_enterprise_companies_page_loaded_successfully()
    {
        $response = $this->get('/enterprise/companies');
        $response->assertStatus(200);

    }

    public function test_enterprise_departments_page_loaded_successfully()
    {
        $response = $this->get('/enterprise/departments');
        $response->assertStatus(200);

    }






}
