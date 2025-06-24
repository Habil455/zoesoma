<?php

namespace Database\Seeders;

use App\Models\SystemModule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $data = [
            ['slug' => 'Dashboard'],
            ['slug' => 'Freelancer Management'],
            ['slug' => 'User Management'],
            ['slug' => 'Customer Management'],
            ['slug' => 'Insurance Management'],
            ['slug' => 'Commissions Management'],
            ['slug' => 'Reports'],
            ['slug' => 'Settings']
        ];
        foreach ($data as $row) {
            SystemModule::updateOrCreate($row);
        }
    }
}
