<!DOCTYPE html>
<html>
<head>
    <title>Cadastro - Controle de Água</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card p-4 my-4">
                    <div class="card-body">
                        <h2 class="text-center mb-4 text-primary fw-bold">Controle de Água</h2>
                        <h5 class="text-center text-muted mb-4">Crie uma nova conta</h5>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome Completo</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Perfil de Acesso</label>
                                <select name="role" id="role" class="form-select" required>
                                    <option value="" disabled selected>Selecione um perfil</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador (Gestor)</option>
                                    <option value="leiturista" {{ old('role') === 'leiturista' ? 'selected' : '' }}>Leiturista</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Senha</label>
                                    <input type="password" name="password" id="password" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                </div>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary btn-lg">Registrar</button>
                            </div>
                            <div class="text-center">
                                <span class="text-muted">Já tem uma conta?</span>
                                <a href="{{ route('login') }}" class="text-decoration-none">Faça Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
