<?php

public function consumidor() { return $this->belongsTo(Consumidor::class); }
public function leitura() { return $this->belongsTo(Leitura::class); }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $guarded = [];
}
