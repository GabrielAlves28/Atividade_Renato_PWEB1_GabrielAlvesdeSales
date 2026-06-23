<?php

namespace App\Http\Controllers;

use App\Models\Consumidor;
use App\Models\LogAcesso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $consumidor = Consumidor::create($request->only(['nome', 'endereco', 'telefone', 'numero_medidor']));

        // Log de Acesso — LGPD: registra a criação do consumidor para prestação de contas
        LogAcesso::create([
            'user_id'       => Auth::id(),
            'consumidor_id' => $consumidor->id,
            'acao'          => 'cadastrou consumidor',
        ]);

        return back()->with('success', 'Consumidor cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes de um consumidor e registra o log de acesso (LGPD).
     */
    public function show(Consumidor $consumidor)
    {
        // Log de Acesso — LGPD: registra visualização de dados do consumidor
        LogAcesso::create([
            'user_id'       => Auth::id(),
            'consumidor_id' => $consumidor->id,
            'acao'          => 'visualizou consumidor',
        ]);

        return back();
    }

    /**
     * Atualiza os dados de um consumidor e registra o log de acesso (LGPD).
     */
    public function update(Request $request, Consumidor $consumidor)
    {
        $consumidor->update($request->only(['nome', 'endereco', 'telefone', 'numero_medidor']));

        // Log de Acesso — LGPD: registra edição de dados do consumidor
        LogAcesso::create([
            'user_id'       => Auth::id(),
            'consumidor_id' => $consumidor->id,
            'acao'          => 'editou consumidor',
        ]);

        return back()->with('success', 'Consumidor atualizado com sucesso!');
    }

    /**
     * Realiza a exclusão lógica (SoftDelete) do consumidor — LGPD.
     * Os dados são preservados no banco (deleted_at é preenchido),
     * garantindo o histórico para prestação de contas.
     */
    public function destroy(Consumidor $consumidor)
    {
        // Log de Acesso — LGPD: registra a desativação do consumidor
        LogAcesso::create([
            'user_id'       => Auth::id(),
            'consumidor_id' => $consumidor->id,
            'acao'          => 'desativou consumidor (soft delete)',
        ]);

        $consumidor->delete(); // SoftDelete: não apaga fisicamente do banco

        return back()->with('success', 'Consumidor desativado com sucesso. Dados preservados conforme LGPD.');
    }
}
