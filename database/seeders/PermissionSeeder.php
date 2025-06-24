<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $data =[

            [1, 'view-setting', 7],
            [2, 'view-roles', 7],
            [3, 'delete-role', 7],
            [4, 'edit-role', 7],
            [5, 'assign-permissions', 7],
            [6, 'view-Permission', 7],
            [7, 'edit-roles', 7],
            [8, 'add-position', 7],

            [9, 'view-customer-mgt-menu', 4],
            [10, 'view-my-customer-registration', 4],
            [11, 'view-all-registration', 4],

            [12, 'view-user-mgt-menu', 3],
            [13, 'view-freelancer-mgt-menu', 2],
        ];

        foreach ($data as $permission) {
            Permission::updateOrCreate([
                // 'id' => $permission[0],
                'slug' => $permission[1],
                'sys_module_id' => $permission[2],
            ]);
        }
    }
}
