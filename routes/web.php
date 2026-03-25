<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgroScanController;
use App\Http\Controllers\Auth\LoginController;

// Tela inicial com brasão
Route::get('/', function () {
    return view('landing');
})->name('landing');

// ROTAS DE AUTENTICAÇÃO
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// TUDO DO SCANNER APENAS PARA USUÁRIOS LOGADOS
Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return redirect()->route('agro.index');
    })->name('dashboard');

    Route::get('/agro', [AgroScanController::class, 'index'])->name('agro.index');
    Route::get('/agro/create', [AgroScanController::class, 'create'])->name('agro.create');
    Route::post('/agro', [AgroScanController::class, 'store'])->name('agro.store');
    Route::get('/agro/{scan}', [AgroScanController::class, 'show'])->name('agro.show');
    Route::get('/agro/{scan}/download', [AgroScanController::class, 'downloadFile'])->name('agro.download');

});