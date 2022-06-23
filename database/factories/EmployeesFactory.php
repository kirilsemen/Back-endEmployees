<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'full_name' => $this->faker->name,
            'birth_date' => $this->faker->date,
            'department_id' => null,
            'position' => null,
            'hourly_payment' => null,
            'payment_per_hour' => null,
            'worked_hours' => null,
            'salary' => 0,
        ];
    }
}
