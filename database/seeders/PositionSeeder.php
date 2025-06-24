<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For Position Data
        $data = [
            ['name' => 'System Administrator','dept_id'=>1,'state' => 1],//By Default
        ];
        foreach ($data as $row) {
            Position::firstOrCreate($row);
        }
    }
}
