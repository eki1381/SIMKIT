<?php

use Illuminate\Database\Seeder;
use App\Positions;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Positions::create([
            'code' => "100",
            'name' => "Kepala Kantor",
            'type' => 1,
            'section_id' => 1
        ]);
        Positions::create([
            'code' => "010",
            'name' => "Kepala Subbagian Tata Usaha",
            'type' => 2,
            'section_id' => 2
        ]);
        Positions::create([
            'code' => "011",
            'name' => "Staf Subbagian Tata Usaha",
            'type' => 3,
            'section_id' => 2
        ]);
        Positions::create([
            'code' => "012",
            'name' => "Bendahara Pengeluaran",
            'type' => 3,
            'section_id' => 2
        ]);
        Positions::create([
            'code' => "020",
            'name' => "Kepala Seksi Statistik Sosial",
            'type' => 2,
            'section_id' => 3
        ]);
        Positions::create([
            'code' => "021",
            'name' => "Staf Seksi Statistik Sosial",
            'type' => 3,
            'section_id' => 3
        ]);
        Positions::create([
            'code' => "030",
            'name' => "Kepala Seksi Statistik Produksi",
            'type' => 2,
            'section_id' => 4
        ]);
        Positions::create([
            'code' => "031",
            'name' => "Staf Seksi Statistik Produksi",
            'type' => 3,
            'section_id' => 4
        ]);
        Positions::create([
            'code' => "040",
            'name' => "Kepala Seksi Statistik Distribusi",
            'type' => 2,
            'section_id' => 5
        ]);
        Positions::create([
            'code' => "041",
            'name' => "Staf Seksi Statistik Distribusi",
            'type' => 3,
            'section_id' => 5
        ]);
        Positions::create([
            'code' => "050",
            'name' => "Kepala Seksi Neraca Wilayah dan Analisis Statistik",
            'type' => 2,
            'section_id' => 6
        ]);
        Positions::create([
            'code' => "051",
            'name' => "Staf Seksi Neraca Wilayah dan Analisis Statistik",
            'type' => 3,
            'section_id' => 6
        ]);
        Positions::create([
            'code' => "060",
            'name' => "Kepala Seksi Integrasi Pengolahan dan Diseminasi Statistik",
            'type' => 2,
            'section_id' => 7
        ]);
        Positions::create([
            'code' => "061",
            'name' => "Staf Seksi Integrasi Pengolahan dan Diseminasi Statistik",
            'type' => 3,
            'section_id' => 7
        ]);
        Positions::create([
            'code' => "101",
            'name' => "Koordinator Statistik Kecamatan",
            'type' => 3,
            'section_id' => 1
        ]);
    }
}
