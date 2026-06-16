<?php

namespace App\Http\Controllers;

use App\Models\Leitura;
use App\Models\Fatura;
use App\Models\ConfiguracaoTaxa;
use Illuminate\Http\Request;

class LeituraController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'leitura_atual' => 'required|numeric|gte:leitura_anterior',
        ], ['leitura_atual.gte' => 'A leitura atual não pode ser menor que a anterior.']);

        $existe = Leitura::where('consumidor_id', $request->consumidor_id)
                         ->where('mes_referencia', $request->mes_referencia)
                         ->where('ano_referencia', $request->ano_referencia)
                         ->first();

        if($existe) {
            return back()->with('error', 'Leitura já registrada para este mês!');
        }

        $consumoM3 = $request->leitura_atual - $request->leitura_anterior;

        $leitura = Leitura::create([
            'consumidor_id' => $request->consumidor_id,
            'mes_referencia' => $request->mes_referencia,
            'ano_referencia' => $request->ano_referencia,
            'leitura_anterior' => $request->leitura_anterior,
            'leitura_atual' => $request->leitura_atual,
            'consumo_m3' => $consumoM3,
        ]);

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
