<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [
                'name' => 'IT',
            ],
            [
                'name' => 'HR',
            ],
            [
                'name' => 'Finance',
            ],
            [
                'name' => 'Marketing',
            ],
            [
                'name' => 'Sales',
            ],
            [
                'name' => 'Accounting',
            ],
            [
                'name' => 'Admin',
            ],
        ];

        Department::insert($departments);
    }
}
