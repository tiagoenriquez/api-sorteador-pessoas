<?php

namespace App\Http\Controllers;

use App\Models\PrimeiroNome;
use Exception;
use Illuminate\Http\Request;

class PrimeiroNomeController extends Controller
{
    public function index()
    {
        try {
            return PrimeiroNome::all();
        } catch (Exception $error) {
            return response("Erro ao listar os primeiros nomes", 404);
        }
    }

    public function store(PrimeiroNome $primeiroNome)
    {
        try {
            $primeiroNome->save();
        } catch (Exception $error) {
            return response("Erro ao inserir o primeiro nome", 404);
        }
    }
}
