<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConsumidorController;
use App\Http\Controllers\LeituraController;
use App\Http\Controllers\ConfiguracaoTaxaController;
use App\Models\Consumidor;
use App\Models\Fatura;
use App\Models\ConfiguracaoTaxa;

Route::get('/', function () {
    // Para garantir que exista uma taxa padrão, criamos se não existir
    if(ConfiguracaoTaxa::count() == 0) {
        ConfiguracaoTaxa::create(['taxa_fixa' => 25, 'valor_excedente' => 2]);
    }

    $consumidores = Consumidor::all();
    $faturas = Fatura::with(['consumidor', 'leitura'])->get();
    $taxa = ConfiguracaoTaxa::first();

    return view('dashboard', compact('consumidores', 'faturas', 'taxa'));
});

Route::post('/consumidores', [ConsumidorController::class, 'store'])->name('consumidores.store');
Route::post('/leituras', [LeituraController::class, 'store'])->name('leituras.store');
Route::post('/taxas', [ConfiguracaoTaxaController::class, 'update'])->name('taxas.update');
Route::post('/faturas/{id}/pagar', function($id) {
    Fatura::find($id)->update(['status' => 'pago']);
    return back();
})->name('faturas.pagar');
