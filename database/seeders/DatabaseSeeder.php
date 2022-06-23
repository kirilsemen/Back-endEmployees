<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employees;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $employees = collect($this->generateEmployees());

        $departments = collect([
            [
                'department_name' => 'Developers',
            ],
            [
                'department_name' => 'Demand',
            ],
            [
                'department_name' => 'Services',
            ],
        ]);

        $employees->map(function ($item) {
            Employees::factory(1)->create(
                $item
            );
        });

        $departments->map(function ($item) {
            Department::factory(1)->create(
                $item
            );
        });

    }

    private function generateEmployees(): array
    {
        $data = [];

        for ($i = 0; $i < 50; $i++) {
            $hours = rand(50, 160);
            $department = rand(1,3);

            if ($i % 2 === 0) {
                $payment = rand(50, 250) / 10;
                $data[] = [
                    'department_id' => $department,
                    'position' => $this->getPosition($department - 1, rand(0,2)),
                    'hourly_payment' => '1',
                    'payment_per_hour' => $payment,
                    'worked_hours' => $hours,
                    'salary' => $hours * $payment
                ];
                continue;
            }

            $salary = rand(5000, 25000) / 10;
            $data[] = [
                'department_id' => $department,
                'position' => $this->getPosition($department - 1, rand(0,2)),
                'hourly_payment' => '0',
                'worked_hours' => $hours,
                'salary' => $salary
            ];
        }

        return $data;
    }

    private function getPosition(int $i, int $position)
    {
        $positions = collect([
            [
                'Developer',
                'Team Lead',
                'Project Manager'
            ],
            [
                'Business Manager',
                'Service Owner',
                'Business Analytic'
            ],
            [
                'Service Owner',
                'Service Manager',
                'Process Lead'
            ],
        ]);

        return $positions[$i][$position];
    }
}
