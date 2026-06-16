<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracaoTaxa extends Model
{
    // Força o Laravel a usar o nome exato da tabela
    protected $table = 'configuracoes_taxa';
    protected $guarded = [];
}
