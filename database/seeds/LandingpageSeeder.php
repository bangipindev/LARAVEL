<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LandingpageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('landingpages')->insert([
            'judul'             => 'duwasisi.com',
            'deskripsi'        => 'Learning Programming',
            'link'              => 'https://halokerja.id/profil',
            'text_link'         => 'Visit',
            'fonticon1'         => '6285747875865',
            'judulfitur1'       => 'Bantul',
            'konten1'           => 'ersajogja@gmail.com',
            'link1'             => 'logo.png',
            'text_link1'        => 'favicon.png',
            'fonticon2'         => '6285747875865',
            'judulfitur2'       => 'Bantul',
            'konten2'           => 'ersajogja@gmail.com',
            'link2'             => 'logo.png',
            'text_link2'        => 'favicon.png',
            'fonticon3'         => '6285747875865',
            'judulfitur3'       => 'Bantul',
            'konten3'           => 'ersajogja@gmail.com',
            'link3'             => 'logo.png',
            'text_link3'        => 'favicon.png'
            
        ]);
    }
}
