<?php

namespace Database\Seeders\Skijasi\Content;

use Illuminate\Database\Seeder;
use NadzorServera\Skijasi\Models\Menu;

class SkijasiContentMenusSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     *
     * @throws Exception
     */
    public function run()
    {
        \DB::beginTransaction();

        try {
            $new_menus = [
                'key' => 'content-module',
                'display_name' => 'Content Manager',
            ];

            Menu::firstOrCreate($new_menus);
        } catch (Exception $e) {
            \DB::rollBack();
        }

        \DB::commit();
    }
}
