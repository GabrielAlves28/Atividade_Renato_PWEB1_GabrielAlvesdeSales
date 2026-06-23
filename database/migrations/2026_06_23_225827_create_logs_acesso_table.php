<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Cria a tabela de logs de acesso para conformidade com a LGPD.
     * Registra quem acessou ou editou dados de consumidores, quando e qual ação foi realizada.
     */
    public function up(): void
    {
        Schema::create('logs_acesso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');         // Quem realizou a ação
            $table->unsignedBigInteger('consumidor_id');   // Dado de qual consumidor foi acessado
            $table->string('acao');                        // Descrição da ação (ex: 'visualizou', 'editou')
            $table->timestamps();                          // created_at serve como data/hora do evento

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('consumidor_id')->references('id')->on('consumidores')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logs_acesso');
    }
};
