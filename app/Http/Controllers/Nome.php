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
            $primeiroNome->nome = $this->obterPrimeiroNome($request->nome);
            $primeiroNome->save();
            $sobrenomes = $this->obterSobrenomes($request->nome);
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
            for ($indice = 0; $indice < $numero; $indice++) {
                $primeiroNome = $this->obterPrimeiroNomeDoBanco();
                $numeroSobrenomes = rand(2, 3);
                $sobrenomes = [];
                for ($indiceSobrenome = 0; $indiceSobrenome < $numeroSobrenomes; $indiceSobrenome++) {
                    array_push($sobrenomes, $this->obterSobrenomeDoBanco());
                }
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
        for ($indice = 0; $nomeCompleto[$indice] != " "; $indice++) {
            $primeiroNome = $primeiroNome."".$nomeCompleto[$indice];
        }
        return $primeiroNome;
    }

    private function obterSobrenomes($nomeCompleto) {
        $sobrenomes = [];
        $sobrenome = "";
        for ($indice = strpos($nomeCompleto, " ") + 1; $indice < strlen($nomeCompleto); $indice++) {
            if ($nomeCompleto[$indice] != " " || !$this->checarMaiusculas(($sobrenome))) {
                $sobrenome = $sobrenome."".$nomeCompleto[$indice];
            } else {
                array_push($sobrenomes, $sobrenome);
                $sobrenome = "";
            }
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

    private function checarMaiusculas($sobrenome) {
        $maiusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for ($i = 0; $i < strlen($maiusculas); $i++) {
            if (preg_match("/".$maiusculas[$i]."/", $sobrenome)) {
                echo "Cheguei aqui";
                return true;
            }
        }
        return false;
    }
}
