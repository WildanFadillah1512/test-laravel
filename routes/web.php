<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::get('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete']);


Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);
Route::get('/master-items/export', [App\Http\Controllers\MasterItemsExportController::class, 'exportExcel']);

Route::get('/master-categories', [App\Http\Controllers\MasterCategoriesController::class, 'index']);
Route::get('/master-categories/search', [App\Http\Controllers\MasterCategoriesController::class, 'search']);
Route::get('/master-categories/form/{method}/{id?}', [App\Http\Controllers\MasterCategoriesController::class, 'formView']);
Route::post('/master-categories/form/{method}/{id?}', [App\Http\Controllers\MasterCategoriesController::class, 'formSubmit']);

Route::get('/master-categories/view/{id}', [App\Http\Controllers\MasterCategoriesController::class, 'singleView']);
Route::get('/master-categories/print/{id}', [App\Http\Controllers\MasterCategoriesController::class, 'printPdf']);
Route::get('/master-categories/delete/{id}', [App\Http\Controllers\MasterCategoriesController::class, 'delete']);
Route::post('/master-categories/api/store', [App\Http\Controllers\MasterCategoriesController::class, 'apiStore']);
