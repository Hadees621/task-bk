<?php
namespace Database\Seeders;

use App\Models\Customers;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    public function run(): void
    {
        Customers::factory()->count(5000)->create();
    }
}
