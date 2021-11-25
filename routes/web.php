<?php

use App\Projeto;
use App\Desenvolvedor;
use App\Alocacao;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// O laravel por default só tras as chaves da tabela intermediária no campo pivô.
// Para trazer os outros campos preciso dizer isso ao laravel.
// Basta ir no model Desenvolvedor e colocar withPivot()
Route::get('/desenvolvedor_projeto', function () {
    
    /* Carregamento preguiçoso
    $desenvolvedores = Desenvolvedor::all();
    */
    $desenvolvedores = Desenvolvedor::with('projetos')->get();

    foreach($desenvolvedores as $d) {
        echo "<p>Nome do Desenvolvedor: ".$d->nome."</p>";
        echo "<p>Cargo: ".$d->cargo."</p>";
        if (count($d->projetos) > 0) {
            echo "Projetos: <br>";
            echo "<ul>";
            foreach($d->projetos as $p) {
                echo "<li>";
                echo "Nome: ".$p->nome." | ";
                echo "Horas dos Projetos: ".$p->estimativa_horas. " | ";
                echo "Horas trabalhadas(Alocação): ".$p->pivot->horas_semanais;
                echo "</li>";
            }
            echo "</ul>";
        }
        echo "<hr>";
    }

    // return $desenvolvedores->toJson();
});

// Aqui é apartir de projeto chegar em desenvolvedor
Route::get('/projeto_desenvolvedor', function () {
    $projetos = Projeto::with('desenvolvedores')->get();

    foreach($projetos as $proj) {
        echo "<p>Nome do Projeto: ".$proj->nome."</p>";
        echo "<p>Cargo: ".$proj->estimativa_horas."</p>";

        if (count($proj->desenvolvedores) > 0) {
            echo "Desenvolvedores: <br>";
            echo "<ul>";

            foreach($proj->desenvolvedores as $d) {
                echo "<li>";
                echo "Nome do Desenvolvedor: ".$d->nome." | ";
                echo "Cargo: ".$d->cargo. " | ";
                echo "Horas trabalhadas(Alocação): ".$d->pivot->horas_semanais;
                echo "</li>";
            }
            echo "</ul>";
        }
    }

    //return $projetos->toJson();
});

// Aqui fiz do ponto de vista do projeto, mas pode ser feito a rota do ponto de vista de desenvolvedores
Route::get('/alocar', function() {
    $proj =  Projeto::find(4);
    if (isset($proj)) {
        // se eu nao usar esssa parte ['horas_semanais' => 50]
        // So vai ser inserido em alocacoes as duas chaves primarias
        // Aqui ele colocar em alocacoes 4 para proj e 1 para desen

        //Esse attach é para inserir 1 por vez
        // $proj->desenvolvedores()->attach(1, ['horas_semanais' => 50]);

        // Para insetir com attach varios de uma vez
        $proj->desenvolvedores()->attach([
            2 => ['horas_semanais' => 20],
            3 => ['horas_semanais' => 30],
        ]);
    }
});

// Desalocando em alocacoes do ponto de vista de projeto, mas poderia fazer do ponto de vista de desenvolvedores
Route::get('/desalocar', function() {
    $proj = Projeto::find(4);
    if (isset($proj)) {
        $proj->desenvolvedores()->detach([1, 2, 3]);
    }
});
