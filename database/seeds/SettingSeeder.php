<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'website'           => 'http://127.0.0.1:8000',
            'nama'              => 'Duwa Sisi',
            'slogan'            => 'Learning Programming',
            'deskripsi_situs'   => 'Duwa Sisi',
            'meta_deskripsi'    => 'Duwa Sisi',
            'telepon'           => '6285747875865',
            'alamat'            => 'Bantul',
            'email_website'     => 'ersajogja@gmail.com',
            'logo'              => 'logo.png',
            'favicon'           => 'favicon.png',
            'facebook'          => 'bangipin15',
            'twitter'           => 'bangipin15',
            'instagram'         => 'bangipin15',
            'linkedin'          => 'bangipin15'
        ]);
    }
}
