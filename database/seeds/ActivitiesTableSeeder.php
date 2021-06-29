<?php

use Illuminate\Database\Seeder;
use App\Activities;

class ActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activities::create([
            'code' => '1953',
            'name' => 'Melakukan pekerjaan perancangan',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1954',
            'name' => 'Melakukan pekerjaan perumusan',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1955',
            'name' => 'Melakukan pekerjaan berkaitan dengan barang dan jasa',
            'volumeUnit' => 'Paket',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1956',
            'name' => 'Melakukan pekerjaan berkaitan dengan kepegawaian',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1961',
            'name' => 'Melakukan alokasi dokumen kegiatan statistik',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1964',
            'name' => 'Melakukan penerimaan dokumen kegiatan statistik',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1966',
            'name' => 'Melakukan pengiriman dokumen kegiatan statistik',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1967',
            'name' => 'Melakukan penyusunan administrasi pelaksanaan kegiatan',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1968',
            'name' => 'Melakukan pekerjaan berkaitan dengan anggaran',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1969',
            'name' => 'Melakukan pekerjaan berkaitan dengan tata kelola kantor',
            'volumeUnit' => 'Paket',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1969',
            'name' => 'Melakukan pekerjaan berkaitan dengan tata kelola kantor',
            'volumeUnit' => 'Paket',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1970',
            'name' => 'Menjadi panitia pelatihan',
            'volumeUnit' => 'Hari',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '3543',
            'name' => 'Melakukan pekerjaan lain',
            'volumeUnit' => 'Kali',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1950',
            'name' => 'Melakukan pekerjaan pemrosesan',
            'volumeUnit' => 'Paket',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '1951',
            'name' => 'Melakukan pekerjaan penyusunan',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '3228',
            'name' => 'Melakukan pekerjaan penyusunan Surat Dinas',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '3232',
            'name' => 'Melakukan rapat/pertemuan',
            'volumeUnit' => 'Laporan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '3341',
            'name' => 'Melakukan manajemen email',
            'volumeUnit' => 'Bulan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '2778',
            'name' => 'Melakukan pengarsipan surat masuk/surat keluar',
            'volumeUnit' => 'Bulan',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '3559',
            'name' => 'Melakukan upload monitoring',
            'volumeUnit' => 'Paket',
            'timeUnit' => 'Hari',
            'section_id' => 2,
        ]);
        Activities::create([
            'code' => '3001',
            'name' => 'Merancang dan membuat jadwal kegiatan statistik',
            'volumeUnit' => 'Rencana jadwal',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4001',
            'name' => 'Merancang dan membuat jadwal kegiatan statistik',
            'volumeUnit' => 'Rencana jadwal',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5001',
            'name' => 'Merancang dan membuat jadwal kegiatan statistik',
            'volumeUnit' => 'Rencana jadwal',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6001',
            'name' => 'Merancang dan membuat jadwal kegiatan statistik',
            'volumeUnit' => 'Rencana jadwal',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7001',
            'name' => 'Merancang dan membuat jadwal kegiatan statistik',
            'volumeUnit' => 'Rencana jadwal',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3002',
            'name' => 'Mengatur alokasi dokumen kegiatan statistik',
            'volumeUnit' => 'Jenis kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4002',
            'name' => 'Mengatur alokasi dokumen kegiatan statistik',
            'volumeUnit' => 'Jenis kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5002',
            'name' => 'Mengatur alokasi dokumen kegiatan statistik',
            'volumeUnit' => 'Jenis kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6002',
            'name' => 'Mengatur alokasi dokumen kegiatan statistik',
            'volumeUnit' => 'Jenis kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7002',
            'name' => 'Mengatur alokasi dokumen kegiatan statistik',
            'volumeUnit' => 'Jenis kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3003',
            'name' => 'Mengatur alokasi perlengkapan petugas kegiatan statistik',
            'volumeUnit' => 'Jenis peralatan',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4003',
            'name' => 'Mengatur alokasi perlengkapan petugas kegiatan statistik',
            'volumeUnit' => 'Jenis peralatan',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5003',
            'name' => 'Mengatur alokasi perlengkapan petugas kegiatan statistik',
            'volumeUnit' => 'Jenis peralatan',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6003',
            'name' => 'Mengatur alokasi perlengkapan petugas kegiatan statistik',
            'volumeUnit' => 'Jenis peralatan',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7003',
            'name' => 'Mengatur alokasi perlengkapan petugas kegiatan statistik',
            'volumeUnit' => 'Jenis peralatan',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3004',
            'name' => 'Merekrut petugas kegiatan statistik',
            'volumeUnit' => 'Petugas',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4004',
            'name' => 'Merekrut petugas kegiatan statistik',
            'volumeUnit' => 'Petugas',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5004',
            'name' => 'Merekrut petugas kegiatan statistik',
            'volumeUnit' => 'Petugas',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6004',
            'name' => 'Merekrut petugas kegiatan statistik',
            'volumeUnit' => 'Petugas',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7004',
            'name' => 'Merekrut petugas kegiatan statistik',
            'volumeUnit' => 'Petugas',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3005',
            'name' => 'Mengikuti pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4005',
            'name' => 'Mengikuti pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5005',
            'name' => 'Mengikuti pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6005',
            'name' => 'Mengikuti pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7005',
            'name' => 'Mengikuti pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3006',
            'name' => 'Memberikan pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4006',
            'name' => 'Memberikan pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5006',
            'name' => 'Memberikan pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6006',
            'name' => 'Memberikan pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7006',
            'name' => 'Memberikan pelatihan',
            'volumeUnit' => 'Jam',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3007',
            'name' => 'Melakukan pengenalan wilayah objek kerja statistik',
            'volumeUnit' => 'Wilayah',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4007',
            'name' => 'Melakukan pengenalan wilayah objek kerja statistik',
            'volumeUnit' => 'Wilayah',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5007',
            'name' => 'Melakukan pengenalan wilayah objek kerja statistik',
            'volumeUnit' => 'Wilayah',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6007',
            'name' => 'Melakukan pengenalan wilayah objek kerja statistik',
            'volumeUnit' => 'Wilayah',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7007',
            'name' => 'Melakukan pengenalan wilayah objek kerja statistik',
            'volumeUnit' => 'Wilayah',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3008',
            'name' => 'Melakukan listing/updating kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4008',
            'name' => 'Melakukan listing/updating kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5008',
            'name' => 'Melakukan listing/updating kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6008',
            'name' => 'Melakukan listing/updating kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7008',
            'name' => 'Melakukan listing/updating kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3009',
            'name' => 'Melakukan pemeriksaan listing/updating kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4009',
            'name' => 'Melakukan pemeriksaan listing/updating kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5009',
            'name' => 'Melakukan pemeriksaan listing/updating kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6009',
            'name' => 'Melakukan pemeriksaan listing/updating kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7009',
            'name' => 'Melakukan pemeriksaan listing/updating kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3010',
            'name' => 'Membuat sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4010',
            'name' => 'Membuat sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5010',
            'name' => 'Membuat sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6010',
            'name' => 'Membuat sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7010',
            'name' => 'Membuat sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3011',
            'name' => 'Memeriksa sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4011',
            'name' => 'Memeriksa sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5011',
            'name' => 'Memeriksa sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6011',
            'name' => 'Memeriksa sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7011',
            'name' => 'Memeriksa sketsa peta wilayah',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3012',
            'name' => 'Melakukan pencacahan/pendataan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4012',
            'name' => 'Melakukan pencacahan/pendataan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5012',
            'name' => 'Melakukan pencacahan/pendataan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6012',
            'name' => 'Melakukan pencacahan/pendataan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7012',
            'name' => 'Melakukan pencacahan/pendataan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3013',
            'name' => 'Melakukan pengumpulan data sekunder',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4013',
            'name' => 'Melakukan pengumpulan data sekunder',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5013',
            'name' => 'Melakukan pengumpulan data sekunder',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6013',
            'name' => 'Melakukan pengumpulan data sekunder',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7013',
            'name' => 'Melakukan pengumpulan data sekunder',
            'volumeUnit' => 'Dokumen',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3014',
            'name' => 'Melakukan pengawasan kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '4014',
            'name' => 'Melakukan pengawasan kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5014',
            'name' => 'Melakukan pengawasan kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6014',
            'name' => 'Melakukan pengawasan kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7014',
            'name' => 'Melakukan pengawasan kegiatan statistik',
            'volumeUnit' => 'Obyek',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3015',
            'name' => 'Melakukan pemeriksaan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4015',
            'name' => 'Melakukan pemeriksaan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5015',
            'name' => 'Melakukan pemeriksaan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6015',
            'name' => 'Melakukan pemeriksaan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7015',
            'name' => 'Melakukan pemeriksaan kegiatan statistik',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3016',
            'name' => 'Melakukan entri data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4016',
            'name' => 'Melakukan entri data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5016',
            'name' => 'Melakukan entri data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6016',
            'name' => 'Melakukan entri data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7016',
            'name' => 'Melakukan entri data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3017',
            'name' => 'Melakukan validasi data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4017',
            'name' => 'Melakukan validasi data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5017',
            'name' => 'Melakukan validasi data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6017',
            'name' => 'Melakukan validasi data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7017',
            'name' => 'Melakukan validasi data',
            'volumeUnit' => 'Kuesioner',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3018',
            'name' => 'Melakukan infografis',
            'volumeUnit' => 'Infografis',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4018',
            'name' => 'Melakukan infografis',
            'volumeUnit' => 'Infografis',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5018',
            'name' => 'Melakukan infografis',
            'volumeUnit' => 'Infografis',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6018',
            'name' => 'Melakukan infografis',
            'volumeUnit' => 'Infografis',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7018',
            'name' => 'Melakukan infografis',
            'volumeUnit' => 'Infografis',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3018',
            'name' => 'Memeriksa tabel publikasi statistik',
            'volumeUnit' => 'Tabel',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4018',
            'name' => 'Memeriksa tabel publikasi statistik',
            'volumeUnit' => 'Tabel',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5018',
            'name' => 'Memeriksa tabel publikasi statistik',
            'volumeUnit' => 'Tabel',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6018',
            'name' => 'Memeriksa tabel publikasi statistik',
            'volumeUnit' => 'Tabel',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7018',
            'name' => 'Memeriksa tabel publikasi statistik',
            'volumeUnit' => 'Tabel',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3019',
            'name' => 'Menyusun publikasi statistik',
            'volumeUnit' => 'Buku',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4019',
            'name' => 'Menyusun publikasi statistik',
            'volumeUnit' => 'Buku',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5019',
            'name' => 'Menyusun publikasi statistik',
            'volumeUnit' => 'Buku',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6019',
            'name' => 'Menyusun publikasi statistik',
            'volumeUnit' => 'Buku',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7019',
            'name' => 'Menyusun publikasi statistik',
            'volumeUnit' => 'Buku',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '3020',
            'name' => 'Menyusun berita resmi statistik',
            'volumeUnit' => 'BRS',
            'timeUnit' => 'Hari',
            'section_id' => 3,
        ]);
        Activities::create([
            'code' => '4020',
            'name' => 'Menyusun berita resmi statistik',
            'volumeUnit' => 'BRS',
            'timeUnit' => 'Hari',
            'section_id' => 4,
        ]);
        Activities::create([
            'code' => '5020',
            'name' => 'Menyusun berita resmi statistik',
            'volumeUnit' => 'BRS',
            'timeUnit' => 'Hari',
            'section_id' => 5,
        ]);
        Activities::create([
            'code' => '6020',
            'name' => 'Menyusun berita resmi statistik',
            'volumeUnit' => 'BRS',
            'timeUnit' => 'Hari',
            'section_id' => 6,
        ]);
        Activities::create([
            'code' => '7020',
            'name' => 'Menyusun berita resmi statistik',
            'volumeUnit' => 'BRS',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
        Activities::create([
            'code' => '7021',
            'name' => 'Membuat peta digital',
            'volumeUnit' => 'Peta',
            'timeUnit' => 'Hari',
            'section_id' => 7,
        ]);
    }
}
