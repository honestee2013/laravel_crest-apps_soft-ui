<?php

namespace Tests\Feature\Livewire;

use App\Modules\DataTableModal;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class DataTableModalTest extends TestCase
{
    /** @test */
    public function renders_successfully()
    {
        Livewire::test(DataTableModal::class)
            ->assertStatus(200);
    }
}
