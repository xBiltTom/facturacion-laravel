<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rutas de registro de empresa (sin middleware company.required)
Route::middleware('auth')->group(function () {
    Route::get('/empresa/registrar', [EmpresaController::class, 'create'])->name('empresa.create');
    Route::post('/empresa/registrar', [EmpresaController::class, 'store'])->name('empresa.store');
});

// Rutas protegidas que requieren empresa registrada
Route::middleware(['auth', 'verified', 'company.required'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Ruta de categorias
    Route::resource('categorias', CategoriaController::class);
});

require __DIR__.'/auth.php';
