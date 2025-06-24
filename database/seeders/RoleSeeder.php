<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'slug' => 'Supervisor',
                'name' => 'Supervisor',
                'added_by'=>1
            ],
            [
                'slug' => 'Freelancer',
                'name' => 'Freelancer',
                'added_by'=>1
            ]
            // [
            //     'slug' => 'Head Of Finance',
            //     'name' => 'Head Of Finance',
            //     'added_by'=>1
            // ],
            // [
            //     'slug' => 'Head Of Human Capital',
            //     'name' => 'Head Of Human Capital',
            //     'added_by'=>1
            // ],
            // [
            //     'slug' => 'Staff',
            //     'name' => 'Staff',
            //     'added_by'=>1
            // ]

        ];

        // insert roles into the 'roles' table

        foreach ($roles as $role) {
            # code...
            Role::updateOrCreate($role);
        }
    }
}
