<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('maps')->insert([
            'nama'              => 'Duwa Sisi',
            'caption'           => 'Duwa Sisi',
            'status'            => '1',
            'embed'             => '0'
        ]);
    }
}
