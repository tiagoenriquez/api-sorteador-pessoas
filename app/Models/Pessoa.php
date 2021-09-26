<?php

namespace App\Models;

class Pessoa
{
    public function __construct($nome, $indice)
    {
        $this->nome = $nome;
        $this->cpf = $this->obterCpf();
        $this->rg = $this->obterRg();
        $this->telefone = $this->obterTelefone();
        $this->usuario = $this->obterUsuario($nome, $indice);
        $this->email = $this->obterEmail($this->usuario);
        $this->senha = $this->obterSenha();
    }

    private function obterCpf()
    {
        $cpf = "";
        for ($i = 0; $i < 11; $i++) {
            $cpf = $cpf . rand(0, 9);
        }
        return $cpf;
    }

    private function obterRg()
    {
        $rg = "";
        for ($i = 0; $i < 10; $i++) {
            $rg = $rg . rand(0, 9);
        }
        return $rg;
    }

    private function obterTelefone()
    {
        $telefone = "99";
        for ($i = 0; $i < 7; $i++) {
            $telefone = $telefone . rand(0, 9);
        }
        return $telefone;
    }

    private function obterUsuario($nome, $indice)
    {
        $primeiroNome = $this->obterPrimeiroNome($nome);
        $ultimoNome = $this->obterUltimoNome($nome);
        $usuarioAcentuado = strtolower($primeiroNome . "." . $ultimoNome . $indice);
        return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/ç/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A c e E i I o O u U n N"),$usuarioAcentuado);
    }

    private function obterEmail($usuario)
    {
        return $usuario . "@tiagao.com";
    }

    private function obterSenha()
    {
        $caracteres = "abcdefghijklmnopqrstuvwxysABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+-*/.,:;!?\/|=(){}[]<>";
        $numeroCaracteres = rand(8, 16);
        $senha = "";
        for ($i = 0; $i < $numeroCaracteres; $i++) {
            $senha = $senha . $caracteres[rand(0, strlen($caracteres) - 1)];
        }
        return $senha;
    }

    private function obterPrimeiroNome($nome)
    {
        $primeiroNome = "";
        for ($i = 0; $nome[$i] != " "; $i++) {
            $primeiroNome = $primeiroNome . $nome[$i];
        }
        return $primeiroNome;
    }

    private function obterUltimoNome($nome)
    {
        $ultimoNome = "";
        for ($i = strlen($nome) - 1; $nome[$i] != " "; $i--) {
            $ultimoNome = $nome[$i] . $ultimoNome;
        }
        return $ultimoNome;
    }
}
