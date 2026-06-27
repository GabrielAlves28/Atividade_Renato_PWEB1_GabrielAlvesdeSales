<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ConfiguracaoTaxa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Cria os usuários de teste e a configuração de taxa padrão.
     */
    public function run(): void
    {
        // Gestor (admin) da associação
        User::firstOrCreate(
            ['email' => 'gestor@associacao.com.br'],
            [
                'name'     => 'Gestor da Associação',
                'password' => Hash::make('senha123'),
                'role'     => 'admin',
            ]
        );

        // Leiturista (operador de campo)
        User::firstOrCreate(
            ['email' => 'leiturista@associacao.com.br'],
            [
                'name'     => 'Leiturista',
                'password' => Hash::make('senha123'),
                'role'     => 'leiturista',
            ]
        );

        // Taxa padrão inicial (criada apenas se não existir)
        ConfiguracaoTaxa::firstOrCreate(
            ['id' => 1],
            [
                'taxa_fixa'       => 25.00,
                'valor_excedente' => 2.00,
            ]
        );
    }
}
