<?php

namespace Database\Seeders\Skijasi\Content;

use Illuminate\Database\Seeder;
use NadzorServera\Skijasi\Models\Permission;

class SkijasiContentPermissionsSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     */
    public function run()
    {
        $keys = [
            'fill_content',
        ];

        foreach ($keys as $key) {
            Permission::firstOrCreate([
                'key' => $key,
                'table_name' => 'content',
                'description' => 'Fill content',
            ]);
        }

        Permission::generateFor('content');
    }
}
