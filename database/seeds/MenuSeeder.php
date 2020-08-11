<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menus')->insert([
            'name'              => 'Primary Menu'
        ]);
        DB::table('menus')->insert([
            'name'              => 'Secondary Menu'
        ]);
        DB::table('menus')->insert([
            'name'              => 'Tersiery Menu'
        ]);
    }
}
