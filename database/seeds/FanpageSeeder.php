<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FanpageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('f_bpages')->insert([
            'applicationid'     => '1',
            'url'               => 'facebook',
            'width'             => '250',
            'height'            => '250'
        ]);
    }
}
