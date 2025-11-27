<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use Carbon\Carbon;

class RichEmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'employee_id' => '321456987',
                'last_name' => 'Dela Cruz',
                'first_name' => 'Juan',
                'middle_name' => 'Santos',
                'designation' => 'Clerk',
                'division' => 'GSD',
                'department' => 'Admin',
                'status' => 'Active',
                'contact' => '09171234567',
                'contact_no' => '09171234567',
                'email' => 'juan.delacruz@example.com',
                'philhealth_no' => '123456789',
                'sex' => 'Male',
                'birthdate' => Carbon::create(1993,5,10),
                'age' => 32,
                'civil_status' => 'Single',
                'religion' => 'Christian',
                'blood_type' => 'O+',
                'notes' => 'No special notes',
            ],
            [
                'employee_id' => '111223333',
                'last_name' => 'Alonzo',
                'first_name' => 'Zak',
                'middle_name' => '',
                'designation' => 'IT Intern',
                'division' => 'MSD',
                'department' => 'IT',
                'status' => 'Active',
                'contact' => '09173451234',
                'contact_no' => '09173451234',
                'email' => 'zak@gmail.com',
                'philhealth_no' => '000000000',
                'sex' => 'Male',
                'birthdate' => Carbon::create(1998,4,12),
                'age' => 27,
                'civil_status' => 'Single',
                'religion' => 'None',
                'blood_type' => 'B+',
                'notes' => 'Intern on contract',
            ],
        ];

        foreach ($employees as $emp) {
            Employee::updateOrCreate([
                'employee_id' => $emp['employee_id']
            ], $emp);
        }
    }
}
