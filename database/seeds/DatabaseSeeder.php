<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            SettingSeeder::class,
            LandingpageSeeder::class,
            MapSeeder::class,
            FanpageSeeder::class,
            ProvinceSeeder::class,
            Cities::class,
            MenuSeeder::class,
        ]);
    }
}
