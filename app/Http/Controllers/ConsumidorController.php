<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use Illuminate\Http\Request;

class ConsumidorController extends Controller
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
        use App\Models\Consumidor;
        use Illuminate\Http\Request;

        public function store(Request $request) {
            Consumidor::create($request->all());
            return back()->with('success', 'Consumidor cadastrado!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Consumidor $consumidor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Consumidor $consumidor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Consumidor $consumidor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Consumidor $consumidor)
    {
        //
    }
}
