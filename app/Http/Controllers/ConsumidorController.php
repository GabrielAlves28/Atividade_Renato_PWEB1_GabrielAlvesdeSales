<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use Illuminate\Http\Request;

class ConsumidorController extends Controller
{
    public function store(Request $request)
    {
        // Adicionamos a validação aqui!
        $request->validate([
            'numero_medidor' => 'unique:consumidores,numero_medidor'
        ], [
            'numero_medidor.unique' => 'Atenção: Este número de medidor já está cadastrado!'
        ]);

        Consumidor::create($request->all());
        return back()->with('success', 'Consumidor cadastrado com sucesso!');
    }
}
