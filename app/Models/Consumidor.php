<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consumidor extends Model
{
    use SoftDeletes;

    // Força o Laravel a usar o plural correto
    protected $table = 'consumidores';
    protected $guarded = [];
}
