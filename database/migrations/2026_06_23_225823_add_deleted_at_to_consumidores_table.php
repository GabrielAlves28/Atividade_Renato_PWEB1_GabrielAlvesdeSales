<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Adiciona suporte a Soft Deletes na tabela de consumidores.
     * Conformidade com a LGPD: dados não são apagados, apenas desativados,
     * preservando o histórico para prestação de contas.
     */
    public function up(): void
    {
        Schema::table('consumidores', function (Blueprint $table) {
            $table->softDeletes(); // adiciona a coluna deleted_at
        });
    }

    public function down(): void
    {
        Schema::table('consumidores', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
