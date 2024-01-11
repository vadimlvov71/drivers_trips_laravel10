<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\DriversTrips;

class DriversTripsFactory extends Factory
{
    use WithFaker;
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DriversTrips::class;

   /* public function __construct()
    {
        $this->setUpFaker();
    }*/
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'driver_id' => $this->faker->numberBetween(999, 1001),
            'pickup' => $this->faker->dateTime()->format('d-m-Y H:i:s'),
            'dropoff' => $this->faker->dateTime()->format('d-m-Y H:i:s'),
        ];
    }
}
