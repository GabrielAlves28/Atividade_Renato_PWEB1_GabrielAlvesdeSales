<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\LeituraController;
use App\Http\Controllers\ConfiguracaoTaxaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Consumidor;
use App\Models\Fatura;
use App\Models\ConfiguracaoTaxa;

// Rotas de Autenticação (Públicas)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
});

// Rotas Protegidas (Requer login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/', function () {
        // Para garantir que exista uma taxa padrão, criamos se não existir
        if(ConfiguracaoTaxa::count() == 0) {
            ConfiguracaoTaxa::create(['taxa_fixa' => 25, 'valor_excedente' => 2]);
        }

        $consumidores = Consumidor::all();
        $faturas = Fatura::with(['consumidor', 'leitura'])->get();
        $taxa = ConfiguracaoTaxa::first();

        return view('dashboard', compact('consumidores', 'faturas', 'taxa'));
    })->name('dashboard');

    // Rota que Leiturista e Admin podem acessar para salvar leituras
    Route::post('/leituras', [LeituraController::class, 'store'])->name('leituras.store');

    // Rotas Administrativas (Apenas Admin)
    Route::middleware('admin')->group(function () {
        Route::post('/consumidores', [ConsumidorController::class, 'store'])->name('consumidores.store');
        Route::post('/taxas', [ConfiguracaoTaxaController::class, 'update'])->name('taxas.update');
        Route::post('/faturas/{id}/pagar', function($id) {
            Fatura::find($id)->update(['status' => 'pago']);
            return back();
        })->name('faturas.pagar');
    });
});
