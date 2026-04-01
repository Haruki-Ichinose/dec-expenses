<?php

use App\Http\Controllers\expenseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [expenseController::class, 'index'])->name('expenses.index');
Route::post('/post', [expenseController::class, 'store'])->name('expenses.store');
Route::delete('expenses/{id}', [expenseController::class, 'destroy'])->name('expenses.destroy');