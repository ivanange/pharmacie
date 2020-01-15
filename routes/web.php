<?php

use App\Command;


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

Route::get('/', function () {
    return view('welcome');
});

Route::resources([
    'categories' => 'CategoryController',
    'products' => 'ProductController',
    'commands' => 'CommandController',
]);



Route::get('/json', function () {
    $data = Command::with('products')->get();
    return $data->toJson();
});

/*
Route::get('/test', function () {
    $cat = new Category;
    $cat2 = new Category;
    $cat->fill(['name' => 'my cat', 'desc' => 'some description']);

    $cat2->id = $cat->id;
    $cat2->name = "cat2";
    $cat2->save();
});


*/
