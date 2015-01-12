<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Bindings
|--------------------------------------------------------------------------
|
*/

require_once app_path().'/routes/bindings.php';

/*
|--------------------------------------------------------------------------
| Route partials
|--------------------------------------------------------------------------
|
*/

require_once app_path().'/routes/partials/base.php';

/*
|--------------------------------------------------------------------------
| Test
|--------------------------------------------------------------------------
|
*/

Route::get('test',function() {

});