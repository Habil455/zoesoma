<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
       // Generate user data here
       $users = [
        [
            'user_code' => 'ZS001',
            'fname' => 'Cornellius',
            'mname' => 'Donald',
            'lname' => 'Tsorai',
            'added_by' => 1,
            'phone' => '+255 623 456 789',
            'emp_id' => 'EMP001',
            'email' => 'user1@example.com',
            'username' => 'user_one',
            'address' => '123 Street, City, Country',
            'birthdate' => '1990-01-01',
            'position' => 1,
            'job_title' => 'Software Engineer',
            'merital_status' => 'Single',
            'password' => Hash::make('password123'),
            'photo' => '/uploads/userprofile/user.png',
            'nationality' => 'American',
            'hire_date' => '2020-06-15',
            'department_id' => 2,
            'designation_id' => 3,
            'joining_date' => Carbon::now(),
            'active_status' => 1,
            'disabled' => 0,
            'disabled_date' => null,
            'email_verified_at' => Carbon::now(),
            'last_updated' => Carbon::now(),
            'created_at' => Carbon::now(),
            'last_login' => Carbon::now()->format('Y-m-d H:i:s'),
            'status' => 1
            // 'region_id' =>2,
            // 'district_id' =>2
        ]
    ];

    // Insert users into the 'users' table
    DB::table('employees')->insert($users);
    }
}
