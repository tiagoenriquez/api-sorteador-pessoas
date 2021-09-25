<?php

namespace App\Http\Controllers;

use App\Models\Pessoa;
use App\Models\PrimeiroNome;
use App\Models\Sobrenome;
use Illuminate\Http\Request;
use Exception;

class NomeController extends Controller
{
    public function inserir(Request $request)
    {
        try {
            $primeiroNomeController = new PrimeiroNomeController();
            $primeiroNome = new PrimeiroNome();
            $primeiroNome->nome = $this->obterPrimeiroNome($request->nome);
            $primeiroNomeController->store($primeiroNome);
            $sobrenomeController = new SobrenomeController();
            $sobrenomes = $this->obterSobrenomes($request->nome);
            foreach ($sobrenomes as $sobrenomeObtido) {
                $sobrenome = new Sobrenome();
                $sobrenome->nome = $sobrenomeObtido;
                $sobrenomeController->store($sobrenome);
            }
            return response("Nomes salvos com sucesso", 201);
        } catch (Exception $error) {
            return response($error->getMessage(), 404);
        }
    }

    public function listar(int $numero)
    {
        try {
            $pessoas = [];
            for ($indice = 0; $indice < $numero; $indice++) {
                $primeiroNome = $this->obterPrimeiroNomeDoBanco();
                $numeroSobrenomes = rand(2, 3);
                $sobrenomes = [];
                for ($indiceSobrenome = 0; $indiceSobrenome < $numeroSobrenomes; $indiceSobrenome++) {
                    array_push($sobrenomes, $this->obterSobrenomeDoBanco());
                }
                $nome = $primeiroNome . " " . $sobrenomes[0] . " " . $sobrenomes[1];
                if (count($sobrenomes) == 3) {
                    $nome = $nome . " " . $sobrenomes[2];
                }
                $pessoa = new Pessoa($nome, $indice);
                array_push($pessoas, $pessoa);
            }
            return $pessoas;
        } catch (Exception $error) {
            return response($error->getMessage(), 404);
        }
    }

    private function obterPrimeiroNome($nomeCompleto)
    {
        $primeiroNome = "";
        for ($indice = 0; $nomeCompleto[$indice] != " "; $indice++) {
            $primeiroNome = $primeiroNome . "" . $nomeCompleto[$indice];
        }
        return $primeiroNome;
    }

    private function obterSobrenomes($nomeCompleto)
    {
        $sobrenomes = [];
        $sobrenome = "";
        for ($indice = strpos($nomeCompleto, " ") + 1; $indice < strlen($nomeCompleto); $indice++) {
            if ($nomeCompleto[$indice] != " " || !preg_match('/\p{Lu}/u', $sobrenome)) {
                $sobrenome = $sobrenome . "" . $nomeCompleto[$indice];
            } else {
                array_push($sobrenomes, $sobrenome);
                $sobrenome = "";
            }
        }
        array_push($sobrenomes, $sobrenome);
        return $sobrenomes;
    }

    private function obterPrimeiroNomeDoBanco()
    {
        $primeiroNomeController = new PrimeiroNomeController();
        $primeirosNomes = $primeiroNomeController->index();
        $numeroPrimeirosNomes = count($primeirosNomes);
        $primeiroNome = $primeirosNomes[rand(0, $numeroPrimeirosNomes - 1)];
        return $primeiroNome->nome;
    }

    private function obterSobrenomeDoBanco()
    {
        $sobrenomeController = new SobrenomeController();
        $sobrenomes = $sobrenomeController->index();
        $numeroSobrenomes = count($sobrenomes);
        $sobrenome = $sobrenomes[rand(0, $numeroSobrenomes - 1)];
        return $sobrenome->nome;
    }
}
