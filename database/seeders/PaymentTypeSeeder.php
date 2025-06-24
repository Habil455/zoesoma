<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $types = [
            [
                'name' => 'Application Fee',
                'amount' => 3000,
                'description'=> 'One time Application Fee',
            ],
            [
                'name' => 'Insurance Fee',
                'amount' => 25000,
                'description'=>'Monthly Insurance Fee',
            ],
        ];

        // Insert payment types into the 'payment_types' table
        foreach ($types as $item) {
            PaymentType::updateorCreate($item);
        }

    }
}
