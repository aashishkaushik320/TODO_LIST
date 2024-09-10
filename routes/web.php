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
use App\Http\Controllers\TaskController;

Route::resource('tasks', TaskController::class);
Route::get('/', function () {
    return view('index');
});

Route::get('get_todo_list',[TaskController::class,'get_todo_list'])->name('get_todo_list');
Route::post('add_task',[TaskController::class,'add_task'])->name('task.add');
Route::post('action',[TaskController::class,'action'])->name('action');
Route::get('get_all',[TaskController::class,'showall'])->name('task.showall');

