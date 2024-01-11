<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Factories\DriverFactory;
use App\Models\DriversTrips;
use App\Http\Controllers\DriversPayableTimeController;

class DriversTripsTest extends TestCase
{
    protected $model = DriversTrips::class;
    protected $controller = DriversPayableTimeController::class;
    /**
     *  test API return the list as desc order
     */
     /**
     *  test API return the list as desc order
     */
    public function testApiListDescReturnsASuccessfulResponse(): void
    {
        $response = $this->get('/angular_order/desc');
        $response->assertStatus(200);

    }
    /**
     * test API return the list as asc order
     * @return void
     */
    public function testApiListAscReturnsASuccessfulResponse(): void
    {
        $response = $this->get('/angular_order/asc');
        $response->assertStatus(200);
    }

    /** @test */
    public function shouldStoreDataInDatabase(): void
    {
        $item = $this->model::factory()->make();
        $data = $item->toArray();
        $this->post(action([$this->controller, 'store']), $data)
            ->assertOk();
    }
  
}
