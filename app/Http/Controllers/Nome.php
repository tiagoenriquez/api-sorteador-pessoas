<?php

namespace App\Http\Controllers;

use App\Models\PrimeiroNome;
use App\Models\Sobrenome;
use Illuminate\Http\Request;
use Exception;

class Nome extends Controller
{
    public function inserir(Request $request) {
        try {
            $primeiroNome = new PrimeiroNome();
            $primeiroNome->nome = $this->obterPrimeiroNome($request["nome"]);
            $primeiroNome->save();
            $sobrenomes = $this->obterSobrenomes($request["nome"]);
            foreach ($sobrenomes as $sobrenomeObtido) {
                $sobrenome = new Sobrenome();
                $sobrenome->nome = $sobrenomeObtido;
                $sobrenome->save();
            }
            return response("Nomes salvos com sucesso", 201);
        } catch(Exception $error) {
            return response("Erro ao inserir os nomes", 404);
        }
    }

    public function listar(int $numero) {
        try {
            $nomes = [];
            $indice = 0;
            while ($indice < $numero) {
                $primeiroNome = $this->obterPrimeiroNomeDoBanco();
                $numeroSobrenomes = rand(2, 3);
                $sobrenomes = [];
                $indiceSobrenome = 0;
                while ($indiceSobrenome < $numeroSobrenomes) {
                    array_push($sobrenomes, $this->obterSobrenomeDoBanco());
                    $indiceSobrenome = $indiceSobrenome + 1;
                }
                $indice = $indice + 1;
                $nome = $primeiroNome." ".$sobrenomes[0]." ".$sobrenomes[1];
                if (count($sobrenomes) == 3) {
                    $nome = $nome." ".$sobrenomes[2];
                }
                array_push($nomes, $nome);
            }
            return $nomes;
        } catch (Exception $error) {
            return response("Erro ao retornar os nomes", 404);
        }
    }

    private function obterPrimeiroNome($nomeCompleto) {
        $primeiroNome = "";
        $indice = 0;
        while ($nomeCompleto[$indice] != " ") {
            $primeiroNome = $primeiroNome."".$nomeCompleto[$indice];
            $indice = $indice + 1;
        }
        return $primeiroNome;
    }

    private function obterSobrenomes($nomeCompleto) {
        $sobrenomes = [];
        $sobrenome = "";
        $indice = strpos($nomeCompleto, " ") + 1;
        while ($indice < strlen($nomeCompleto)) {
            if ($nomeCompleto[$indice] != " " || !preg_match("/\p{Lu}/u", $sobrenome)) {
                $sobrenome = $sobrenome."".$nomeCompleto[$indice];
            } else {
                array_push($sobrenomes, $sobrenome);
                $sobrenome = "";
            }
            $indice = $indice + 1;
        }
        array_push($sobrenomes, $sobrenome);
        return $sobrenomes;
    }

    private function obterPrimeiroNomeDoBanco() {
        $primeiroNome = PrimeiroNome::all()[rand(1, PrimeiroNome::count())];
        return $primeiroNome->nome;
    }

    private function obterSobrenomeDoBanco() {
        $sobrenome = Sobrenome::all()[rand(1, Sobrenome::count())];
        return $sobrenome->nome;
    }
}
