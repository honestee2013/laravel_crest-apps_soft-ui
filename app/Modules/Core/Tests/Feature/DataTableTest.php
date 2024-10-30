<?php

namespace app\Modules\Core\Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\Core\Livewire\DataTables\DataTable;
use App\Modules\Core\Livewire\DataTables\DataTableManager;
use App\Modules\Core\Traits\DataTable\DataTableControlsTrait;
use App\Modules\Core\Traits\DataTable\DataTableFieldsConfigTrait;

class DataTableTest extends TestCase
{

    use DataTableFieldsConfigTrait, DataTableControlsTrait;

    /** @test */
    public function test_datatable_loaded_successfully()
    {
        Livewire::test(DataTableManager::class, ['model' => "App\\Models\\User", "moduleName" => "Core"])
        ->assertSee( 'User Record');
    }



}
