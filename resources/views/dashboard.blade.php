<!DOCTYPE html>
<html>
<head>
    <title>Controle de Água</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Associação Comunitária - Água</h1>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted">
                    Olá, <strong>{{ auth()->user()->name }}</strong> ({{ ucfirst(auth()->user()->role) }})
                </span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Sair</button>
                </form>
            </div>
        </div>

        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        <div class="row">
            @if(auth()->user()->isAdmin())
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Cadastrar Consumidor</div>
                    <div class="card-body">
                        <form action="{{ route('consumidores.store') }}" method="POST">
                            @csrf
                            <input type="text" name="nome" class="form-control mb-2" placeholder="Nome" required>
                            <input type="text" name="endereco" class="form-control mb-2" placeholder="Endereço" required>
                            <input type="text" name="telefone" class="form-control mb-2" placeholder="Telefone (ex: 88999999999)" required>
                            <input type="text" name="numero_medidor" class="form-control mb-2" placeholder="Nº Medidor" required>
                            <button class="btn btn-primary">Salvar Consumidor</button>
                        </form>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">Configurar Taxas</div>
                    <div class="card-body">
                        <form action="{{ route('taxas.update') }}" method="POST">
                            @csrf
                            Taxa Fixa (Até 10m³): <input type="number" step="0.01" name="taxa_fixa" value="{{ $taxa->taxa_fixa }}" class="form-control mb-2">
                            Valor Excedente (Por m³): <input type="number" step="0.01" name="valor_excedente" value="{{ $taxa->valor_excedente }}" class="form-control mb-2">
                            <button class="btn btn-warning">Atualizar Taxas</button>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="{{ auth()->user()->isAdmin() ? 'col-md-6' : 'col-md-8 mx-auto' }}">
                <div class="card mb-4">
                    <div class="card-header">Registrar Leitura Mensal</div>
                    <div class="card-body">
                        <form action="{{ route('leituras.store') }}" method="POST">
                            @csrf
                            <select name="consumidor_id" class="form-control mb-2" required>
                                <option value="">Selecione o Consumidor</option>
                                @foreach($consumidores as $c)
                                    <option value="{{ $c->id }}">{{ $c->nome }} - Medidor: {{ $c->numero_medidor }}</option>
                                @endforeach
                            </select>
                            <div class="d-flex gap-2 mb-2">
                                <input type="number" name="mes_referencia" class="form-control" placeholder="Mês (ex: 6)" required>
                                <input type="number" name="ano_referencia" class="form-control" placeholder="Ano (ex: 2026)" required>
                            </div>
                            <input type="number" step="0.01" name="leitura_anterior" class="form-control mb-2" placeholder="Leitura Anterior (m³)" required>
                            <input type="number" step="0.01" name="leitura_atual" class="form-control mb-2" placeholder="Leitura Atual (m³)" required>
                            <button class="btn btn-success">Registrar e Gerar Fatura</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->isAdmin())
        <div class="card">
            <div class="card-header">Faturas Geradas</div>
            <div class="card-body">
                <table class="table">
                    <thead><tr><th>Consumidor</th><th>Mês/Ano</th><th>Consumo</th><th>Valor</th><th>Status</th><th>Ações</th></tr></thead>
                    <tbody>
                        @foreach($faturas as $f)
                        @php
                               $msg = "Olá, {$f->consumidor->nome}! Segue o consumo de {$f->leitura->mes_referencia}/{$f->leitura->ano_referencia}:\n\nLeitura atual: {$f->leitura->leitura_atual} m³\nMedidor: {$f->consumidor->numero_medidor}\nLeitura anterior: {$f->leitura->leitura_anterior} m³\nConsumo: {$f->leitura->consumo_m3} m³\n(".($f->leitura->consumo_m3 * 1000)." litros)\n\nValor da fatura: R$ {$f->valor_total}\n\nAtt, Associação Comunitária";

                               // Limpa o telefone, deixando APENAS os números
                               $telefoneLimpo = preg_replace('/[^0-9]/', '', $f->consumidor->telefone);

                               $link = "https://wa.me/55{$telefoneLimpo}?text=" . urlencode($msg);
                           @endphp
                        <tr>
                            <td>{{ $f->consumidor->nome }}</td>
                            <td>{{ $f->leitura->mes_referencia }}/{{ $f->leitura->ano_referencia }}</td>
                            <td>{{ $f->leitura->consumo_m3 }} m³</td>
                            <td>R$ {{ number_format($f->valor_total, 2, ',', '.') }}</td>
                            <td>{{ $f->status }}</td>
                            <td>
                                <a href="{{ $link }}" target="_blank" class="btn btn-sm btn-success">WhatsApp</a>
                                @if($f->status == 'pendente')
                                    <form action="{{ route('faturas.pagar', $f->id) }}" method="POST" class="d-inline">
                                        @csrf <button class="btn btn-sm btn-info">Marcar Pago</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</body>
</html>
