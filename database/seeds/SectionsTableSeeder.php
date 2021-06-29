<?php

use Illuminate\Database\Seeder;
use App\Sections;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sections::create([
            'name' => "BPS Kabupaten Kepulauan Anambas",
            'code' => "92800",
            'color' => "#000000",
        ]);
        Sections::create([
            'name' => "Subbagian Tata Usaha",
            'code' => "92810",
            'color' => "#795548",
        ]);
        Sections::create([
            'name' => "Seksi Statistik Sosial",
            'code' => "92820",
            'color' => "#2196f3",
        ]);
        Sections::create([
            'name' => "Seksi Statistik Produksi",
            'code' => "92830",
            'color' => "#4caf50",
        ]);
        Sections::create([
            'name' => "Seksi Statistik Distribusi",
            'code' => "92840",
            'color' => "#ff9800",
        ]);
        Sections::create([
            'name' => "Seksi Statistik Neraca Wilayah dan Analisis Statistik",
            'code' => "92850",
            'color' => "#9c27b0",
        ]);
        Sections::create([
            'name' => "Seksi Integrasi Pengolahan dan Diseminasi Statistik",
            'code' => "92860",
            'color' => "#ffeb3b",
        ]);
    }
}
