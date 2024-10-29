<?php

namespace app\Modules\Core\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Core\Livewire\DataTables\DataTable;
use App\Modules\Core\Livewire\DataTables\DataTableManager;

class DataTableManagerTest extends TestCase
{


    /** @test */
    public function test_datatable_manager_page_loaded_successfully()
    {
        $response = $this->get('/core/test-data-table-manager'); // Adjust this path to match your route
        $response->assertStatus(200);
    }


    public function test_datatable_manager_model_and_module_name_initiated_successfully(): void
    {
        Livewire::test(DataTableManager::class, ['model' => "App\\Models\\User", "moduleName" => "Core"])
        ->assertSet('model', 'App\\Models\\User')
        ->assertSet('moduleName', 'Core');
    }




    public function test_datatable_manager_table_fields_definitions_initiated_successfully(): void
    {
        $component = Livewire::test(DataTableManager::class, ['model' => "App\\Models\\User"]);
        $this->assertNotEmpty($component->fieldDefinitions);
    }


    public function test_datatable_manager_model_config_file_loaded_successfully(): void
    {
        $component = Livewire::test(DataTableManager::class, ['model' => "App\\Models\\User", "moduleName" => "Core"]);
        // If config file is loaded successfully and user wants the 'ID' field to be part of the 'fieldDefinitions
        // then the 'ID' data type must not be 'bigint' (which is assign by default) when config file is absent
        if (isset($component->fieldDefinitions['id']))
            $this->assertNotEquals($component->fieldDefinitions['id'], "bigint");
        else  // If config file is loaded, 'ID' field is not expected to be part of 'fieldDefinitions
            $this->assertFalse(isset($component->fieldDefinitions['id']));
    }





}
