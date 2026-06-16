<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use Illuminate\Http\Request;

class LeituraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       use App\Models\Leitura;
       use App\Models\Fatura;
       use App\Models\ConfiguracaoTaxa;
       use Illuminate\Http\Request;

       public function store(Request $request) {
           $request->validate([
               'leitura_atual' => 'required|numeric|gte:leitura_anterior',
           ], ['leitura_atual.gte' => 'A leitura atual não pode ser menor que a anterior.']);

           // Verifica se já existe leitura no mês [cite: 35]
           $existe = Leitura::where('consumidor_id', $request->consumidor_id)
                            ->where('mes_referencia', $request->mes_referencia)
                            ->where('ano_referencia', $request->ano_referencia)
                            ->first();
           if($existe) return back()->with('error', 'Leitura já registrada para este mês!');

           // Cálculo do Consumo [cite: 34]
           $consumoM3 = $request->leitura_atual - $request->leitura_anterior;

           $leitura = Leitura::create([
               'consumidor_id' => $request->consumidor_id,
               'mes_referencia' => $request->mes_referencia,
               'ano_referencia' => $request->ano_referencia,
               'leitura_anterior' => $request->leitura_anterior,
               'leitura_atual' => $request->leitura_atual,
               'consumo_m3' => $consumoM3,
           ]);

           // Cálculo da Fatura [cite: 27, 28]
           $taxa = ConfiguracaoTaxa::first();
           $valorTotal = $taxa->taxa_fixa;

           if ($consumoM3 > 10) {
               $valorTotal += (($consumoM3 - 10) * $taxa->valor_excedente);
           }

           Fatura::create([
               'consumidor_id' => $request->consumidor_id,
               'leitura_id' => $leitura->id,
               'valor_total' => $valorTotal,
           ]);

           return back()->with('success', 'Leitura e Fatura geradas!');
       }
    }

    /**
     * Display the specified resource.
     */
    public function show(Leitura $leitura)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leitura $leitura)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leitura $leitura)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leitura $leitura)
    {
        //
    }
}
