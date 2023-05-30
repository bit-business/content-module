<?php

namespace Database\Seeders\Skijasi\Content;

use Illuminate\Database\Seeder;
use NadzorServera\Skijasi\Models\Menu;
use NadzorServera\Skijasi\Models\MenuItem;

class SkijasiContentFixedMenuItemSeeder extends Seeder
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
            $menus = Menu::where('key', 'content-module')->first();
            $menu_id = $menus->id;

            $add_menus_item = [
                'menu_id' => $menu_id,
                'title' => 'Content Manager',
                'url' => '/content',
                'target' => '_self',
                'icon_class' => 'dashboard_customize',
                'color' => '',
                'parent_id' => null,
                'order' => 2,
                'permissions' => 'browse_content',
            ];

            MenuItem::firstOrCreate($add_menus_item);
        } catch (Exception $e) {
            \DB::rollBack();
        }

        \DB::commit();
    }
}
