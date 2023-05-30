---
sidebar_position: 1
---

# Installation

1. Install skijasi first. After that, you can install the module with the following command.

    ```bash
    composer require skijasi/content-module
    ```

1. Run the following command to easily setup the module.

    ```bash
    php artisan skijasi-content:setup
    php artisan migrate
    composer dump-autoload
    php artisan db:seed --class="Database\Seeders\Skijasi\Content\SkijasiContentModuleSeeder"
    ```

1. Add the plugins to your `MIX_SKIJASI_PLUGINS` to `.env`. If you have another plugins installed, include them using delimiter comma (,).

    ```
    MIX_SKIJASI_PLUGINS=content-module
    ```

1. Add the plugins menu to your `MIX_SKIJASI_MENU` to `.env`. If you have another menu, include them using delimiter comma (,).

    ```
    MIX_SKIJASI_MENU=${MIX_DEFAULT_MENU},content-module
    ```
    
1. Install & compile the JS `npm install && npm run dev`