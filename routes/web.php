<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PuraController;

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



Route::get('/', [PuraController::class, 'index']);
Route::post('/pura', [PuraController::class, 'store'])->name('pura.store');


Route::get('/pura/{pura}/edit', [PuraController::class, 'edit'])->name('pura.edit');
Route::put('/pura/{pura}', [PuraController::class, 'update'])->name('pura.update');
Route::delete('/pura/{pura}', [PuraController::class, 'destroy'])->name('pura.destroy');

Route::get('/api/puras', [PuraController::class, 'getPurasData']);
