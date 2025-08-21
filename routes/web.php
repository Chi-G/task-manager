<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('tasks', TaskController::class);
Route::post('tasks/reorder', [TaskController::class, 'reorder'])->name('tasks.reorder');
Route::resource('projects', ProjectController::class);
