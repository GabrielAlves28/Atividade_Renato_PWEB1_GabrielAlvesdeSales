<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumidor extends Model
{
    // Força o Laravel a usar o plural correto
    protected $table = 'consumidores';
    protected $guarded = [];
}
