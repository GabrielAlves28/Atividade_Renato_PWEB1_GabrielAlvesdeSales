<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    // Permite salvar em todas as colunas
    protected $guarded = [];

    // As relações precisam ficar AQUI DENTRO da classe
    public function consumidor() {
        return $this->belongsTo(Consumidor::class);
    }

    public function leitura() {
        return $this->belongsTo(Leitura::class);
    }
}
