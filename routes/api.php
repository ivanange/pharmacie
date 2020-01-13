<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Json;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'categories' => 'CategoryController',
    'products' => 'ProductController',
    'commands' => 'CommandController',
], ['middleware' => "json"]);

/*
Route::middleware(['json'])->group(function () {

    Route::apiResources([
        'categories' => 'CategoryController',
        'products' => 'ProductController',
        'commands' => 'CommandController',
    ]);
});

Route::apiResources([
    'categories' => 'CategoryController',
    'products' => 'ProductController',
    'commands' => 'CommandController',
]);
*/
