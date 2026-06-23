<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model de Log de Acesso — para conformidade com a LGPD.
 * Registra toda vez que dados de um consumidor são visualizados ou editados.
 */
class LogAcesso extends Model
{
    protected $table = 'logs_acesso';

    protected $fillable = [
        'user_id',
        'consumidor_id',
        'acao',
    ];

    /**
     * Relação: o log pertence a um usuário (quem realizou a ação).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relação: o log pertence a um consumidor (cujos dados foram acessados).
     */
    public function consumidor()
    {
        return $this->belongsTo(Consumidor::class);
    }
}
