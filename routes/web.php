<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Middleware\IdentifyTenant;
use App\Http\Middleware\SetTenantDatabase;

Route::middleware([IdentifyTenant::class])->group(function () {
    Route::domain('{tenant}.bagisto')->group(function () {
        // Tenant-specific routes
        Route::get('/', 'TenantController@index');
        // ...
    });

    // Shared routes for non-tenant-specific pages
    Route::get('/', 'HomeController@index');
    // ...
});

Route::middleware([ SetTenantDatabase::class])->group(function () {
    Route::domain('{tenant}.bagisto')->group(function () {
        Route::get('test', 'TenantController@index');

    });
});
