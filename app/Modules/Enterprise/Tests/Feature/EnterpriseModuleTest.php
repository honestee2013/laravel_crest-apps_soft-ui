<?php

namespace app\Modules\Core\Tests\Feature;

use Tests\TestCase;


class EnterpriseModuleTest extends TestCase
{


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
