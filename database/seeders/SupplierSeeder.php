<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        Supplier::insert([
            [
                'name' => 'PT Sehat Selalu',
                'address' => 'Jakarta',
                'phone' => '08123456789'
            ],
            [
                'name' => 'CV Hidup Bahagia',
                'address' => 'Bandung',
                'phone' => '08129876543'
            ],
        ]);
    }
}
