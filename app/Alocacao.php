<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alocacao extends Model
{
    // Precisei fazer, pois o laravel coloca S (alocacaos), mas eu quero (Alocacoes).
    protected $table = "alocacoes";

}
