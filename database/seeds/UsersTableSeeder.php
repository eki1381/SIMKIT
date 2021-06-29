<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Donny Cahyo Wibowo SST, M.Si.",
            'email' => "donny@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340016453_20170324104730.jpg",
            'admin' => 0,
            'ein' => "197902032002121008",
            'section_id' => 1,
            'position_id' => 1,
        ]);
        User::create([
            'name' => "Ahmad Lutfi Aziz S.Tr.Stat.",
            'email' => "ahmad.lutfi@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340059385.jpg",
            'admin' => 0,
            'ein' => "199706062019121001",
            'section_id' => 5,
            'position_id' => 10,
        ]);
        User::create([
            'name' => "Nur Aliyah Adewita Saragih S.Tr.Stat.",
            'email' => "aliyah.saragih@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340059680.jpg",
            'admin' => 0,
            'ein' => "199612162019122001",
            'section_id' => 3,
            'position_id' => 5,
        ]);
        User::create([
            'name' => "Martin Dwi Kristianto S.Tr.Stat.",
            'email' => "martin.dwik@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340059622.jpg",
            'admin' => 0,
            'ein' => "199803232019121002",
            'section_id' => 4,
            'position_id' => 9,
        ]);
        User::create([
            'name' => "Juniarita Ratnasari S.Tr.Stat.",
            'email' => "juniarita.ratnasari@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340058796.jpg",
            'admin' => 0,
            'ein' => "199606112019012002",
            'section_id' => 4,
            'position_id' => 8,
        ]);
        User::create([
            'name' => "Ruth Yuliani Hutabarat SST",
            'email' => "ruth.hutabarat@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340057709.jpg",
            'admin' => 0,
            'ein' => "199407082017012001",
            'section_id' => 5,
            'position_id' => 9,
        ]);
        User::create([
            'name' => "Ruri Alifia Ramadhani S.Tr.Stat",
            'email' => "ruri.alifia@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340059756_20200302175543.jpg",
            'admin' => 0,
            'ein' => "199701122019122001",
            'section_id' => 6,
            'position_id' => 11,
        ]);
        User::create([
            'name' => "Riko Tri Utama SST",
            'email' => "riko.tri@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340058461.jpg",
            'admin' => 0,
            'ein' => "199408212018021001",
            'section_id' => 7,
            'position_id' => 13,
        ]);
        User::create([
            'name' => "Suparto",
            'email' => "suparto@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340020055_20190703100859.jpg",
            'admin' => 0,
            'ein' => "198706022008011001",
            'section_id' => 2,
            'position_id' => 4,
        ]);
        User::create([
            'name' => "Yohanes Eki Apriliawan SST",
            'email' => "yohanes.apriliawan@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340057710.jpg",
            'admin' => 1,
            'ein' => "199404122017011001",
            'section_id' => 7,
            'position_id' => 13,
        ]);
        User::create([
            'name' => "Reza Vahlevi SST",
            'email' => "reza.vahlevi@bps.go.id",
            'email_verified_at' => now(),
            'password' => bcrypt('admin2105'),
            'photo' => "https://community.bps.go.id/images/avatar/340057553_20190716143556.jpg",
            'admin' => 0,
            'ein' => "199306132016021001",
            'section_id' => 3,
            'position_id' => 5,
        ]);
    }
}
