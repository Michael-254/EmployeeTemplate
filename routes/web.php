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
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/index', [App\Http\Controllers\EmployeeTemplateController::class, 'index'])->name('index');

Route::post('/store', [App\Http\Controllers\EmployeeTemplateController::class, 'store'])->name('store');
Route::post('/storeB', [App\Http\Controllers\EmployeeTemplateController::class, 'storeB'])->name('storeB');
Route::post('/storeC', [App\Http\Controllers\EmployeeTemplateController::class, 'storeC'])->name('storeC');
Route::put('/update/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'update'])->name('update');
Route::put('/updateB/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'updateB'])->name('updateB');
Route::put('/updateC/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'updateC'])->name('updateC');
Route::post('/upload', [App\Http\Controllers\EmployeeTemplateController::class, 'upload'])->name('upload');
Route::delete('/remove/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'destroy'])->name('remove');
//file
Route::get('/View/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'file'])->name('report.file');
Route::get('AdminView/View/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'file'])->name('report.file2');

Route::get('/Admin', [App\Http\Controllers\EmployeeTemplateController::class, 'Admin'])->name('Admin');
Route::get('/EmployeeView/{id}', [App\Http\Controllers\EmployeeTemplateController::class, 'Adminview'])->name('Admin.view');

Route::post('/logout', function () {
    return Auth::logout();
});

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
