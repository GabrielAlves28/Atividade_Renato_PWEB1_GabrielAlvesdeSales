<?php

namespace App\Http\Controllers;

use App\Models\ConfiguracaoTaxa;
use Illuminate\Http\Request;

class ConfiguracaoTaxaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ConfiguracaoTaxa $configuracaoTaxa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ConfiguracaoTaxa $configuracaoTaxa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ConfiguracaoTaxa $configuracaoTaxa)
    {
       use App\Models\ConfiguracaoTaxa;
       use Illuminate\Http\Request;

       public function update(Request $request) {
           $taxa = ConfiguracaoTaxa::first();
           $taxa->update($request->all());
           return back()->with('success', 'Taxa atualizada!');
       }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ConfiguracaoTaxa $configuracaoTaxa)
    {
        //
    }
}
