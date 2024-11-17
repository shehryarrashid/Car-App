<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cars')->insert(['make' => 'Volkswagen', 'model' => 'Golf GTD', 'year' => 2024, 'mileage' => 12000, 'category' => 'clear']);
        DB::table('cars')->insert(['make' => 'BMW', 'model' => '340i', 'year' => 2019, 'mileage' => 51975, 'category' => 'clear']);
        DB::table('cars')->insert(['make' => 'Audi', 'model' => 'A4', 'year' => 2013, 'mileage' => 132000, 'category' => 's']);
        DB::table('cars')->insert(['make' => 'Kia', 'model' => 'Sportage', 'year' => 2015, 'mileage' => 65945, 'category' => 'n']);
        DB::table('cars')->insert(['make' => 'Nissan', 'model' => 'Aria', 'year' => 2024, 'mileage' => 295, 'category' => 's']);
        DB::table('cars')->insert(['make' => 'Jaguar', 'model' => 'F-Type', 'year' => 2019, 'mileage' => 6752, 'category' => 'b']);
    }
}
