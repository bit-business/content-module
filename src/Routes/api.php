<?php

use Illuminate\Support\Facades\Route;
use NadzorServera\Skijasi\Middleware\ApiRequest;
use NadzorServera\Skijasi\Middleware\SkijasiCheckPermissions;
use NadzorServera\Skijasi\Module\Content\Helpers\Route as HelpersRoute;

$api_route_prefix = \config('skijasi.api_route_prefix');

Route::group(
    [
        'prefix' => $api_route_prefix,
        'as' => 'skijasi.',
        'middleware' => [ApiRequest::class],
    ],
    function () {
        Route::group(['prefix' => 'module/content/v1'], function () {
            Route::group(['prefix' => 'content'], function () {
                Route::get('/', HelpersRoute::getController('ContentController@browse'))->middleware(SkijasiCheckPermissions::class.':browse_content');
                Route::get('/read', HelpersRoute::getController('ContentController@read'))->middleware(SkijasiCheckPermissions::class.':read_content');
                Route::get('/fetch', HelpersRoute::getController('ContentController@fetch'));
                Route::get('/fetch-multiple', HelpersRoute::getController('ContentController@fetchMultiple'));
                Route::post('/add', HelpersRoute::getController('ContentController@add'))->middleware(SkijasiCheckPermissions::class.':add_content');
                Route::put('/fill', HelpersRoute::getController('ContentController@fill'))->middleware(SkijasiCheckPermissions::class.':fill_content');
                Route::put('/edit', HelpersRoute::getController('ContentController@edit'))->middleware(SkijasiCheckPermissions::class.':edit_content');
                Route::delete('/delete', HelpersRoute::getController('ContentController@delete'))->middleware(SkijasiCheckPermissions::class.':delete_content');
                Route::delete('/delete-multiple', HelpersRoute::getController('ContentController@deleteMultiple'))->middleware(SkijasiCheckPermissions::class.':delete_content');
            });
        });
    }
);
