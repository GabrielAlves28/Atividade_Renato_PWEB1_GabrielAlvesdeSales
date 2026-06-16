<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoTaxa;
use Illuminate\Http\Request;

class ConfiguracaoTaxaController extends Controller
{
    public function update(Request $request)
    {
        $taxa = ConfiguracaoTaxa::first();
        $taxa->update($request->all());
        return back()->with('success', 'Taxa atualizada!');
    }
}
