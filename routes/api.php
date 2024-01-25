<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

// Removed unnecessary routes.
// Used for API call


Route::resource('tasks', TodoController::class);

Route::put('tasks/{task}/complete', [TodoController::class, 'complete'])->name('task.complete');
