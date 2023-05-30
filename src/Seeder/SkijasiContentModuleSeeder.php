<?php

namespace Database\Seeders\Skijasi\Content;

use Illuminate\Database\Seeder;

class SkijasiContentModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SkijasiContentPermissionsSeeder::class);
        $this->call(SkijasiContentRolePermissionsSeeder::class);
        $this->call(SkijasiContentMenusSeeder::class);
        $this->call(SkijasiContentFixedMenuItemSeeder::class);
    }
}
