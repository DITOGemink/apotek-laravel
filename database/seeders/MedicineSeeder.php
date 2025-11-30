<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        Medicine::insert([
            [
                'name' => 'Paracetamol',
                'stock' => 100,
                'price' => 5000,
                'category_id' => 2,
                'exp_date' => '2026-01-01',
            ],
            [
                'name' => 'Amoxicillin',
                'stock' => 50,
                'price' => 8000,
                'category_id' => 1,
                'exp_date' => '2027-03-10',
            ],
        ]);
    }
}
