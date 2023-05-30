

## Development Workflow

Before develop the Skijasi Content Module Make sure you have the skijasi library in the `/laravel-project/packages/nadzorservera-croatia/` folder, for Skijasi develop please check the following link [Contributing](https://github.com/nadzorservera-croatia/skijasi/blob/main/CONTRIBUTING.md)

### Installation step

After getting the license, you can proceed to Skijasi installation.

1, Clone skijasi into Laravel project. Sample:
- Root Laravel Project
  - /packages (Folder Packages)
    - /nadzorservera-croatia (Folder NadzorServera Indonesia)
      - core (Skijasi Core Library) 
      - content-module (Cloud Skijasi Content Manager)
    - ...
  - ...
- ...

cd into nadzorservera-croatia directory, then run
```
git clone https://github.com/nadzorservera-croatia/skijasi-content-module.git content-module

```

2. Add the following Skijasi provider to ```/config/app.php```.

```
'providers' => [
  ...,
  NadzorServera\Skijasi\Module\Content\Providers\SkijasiContentModuleServiceProvider::class,
]
```

3. Add skijasi providers to autoload

```
"autoload": {
    "psr-4": {
        "App\\": "app/",
        "NadzorServera\\Skijasi\\": "packages/skijasi/skijasi/src/",
        "NadzorServera\\Skijasi\\Module\\Content\\": "packages/skijasi/content-module/src/",
    },
    ...
}
```

5. Copy required library from ```packages/skijasi/content-module/composer.json``` to ```/composer.json``` then ```composer install```

6. Run the following commands in sequence.
```
php artisan migrate
```

7. Run the following commands to update dependencies in package.json and webpack.
```
php artisan skijasi-content:setup
```
if you want to overwrite the file 
```
php artisan skijasi-content:setup --force
```

8. Run command 
```
composer dump-autoload
```
9. Run command 
```
php artisan db:seed --class=SkijasiContentModuleSeeder
```
11. Open the ```env``` file then add the following lines.
```
MIX_DEFAULT_MENU=admin
MIX_SKIJASI_MENU=${MIX_DEFAULT_MENU},content-module
MIX_SKIJASI_PLUGINS=content-module
```

9. In menu item "Role Management" from skijasi admin panel, add permission user to fill content
![image](https://user-images.githubusercontent.com/55905844/118775952-a90f3380-b8b1-11eb-9c32-d672f686aeb1.png)

## Running the tests

To do : complete this section

---

### Reporting an issue

Before submitting an issue you need to make sure:

- You are experiencing a concrete technical issue with Skijasi Content Module.
- You have already searched for related [issues](https://github.com/nadzorservera-croatia/skijasi-content-module/issues), and found none open (if you found a related _closed_ issue, please link to it from your post).
- You are not asking a question about how to use Skijasi or about whether or not Skijasi has a certain feature. For general help using Skijasi, you may:
  - Refer to [the official Skijasi Content Module documentation](https://github.com/nadzorservera-croatia/skijasi-content-module).
  - Ask a question on [github discussion](https://github.com/nadzorservera-croatia/skijasi-content-module/discussions).
- Your issue title is concise, on-topic and polite.
- You can and do provide steps to reproduce your issue.
