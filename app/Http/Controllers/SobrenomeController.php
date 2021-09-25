<?php

namespace App\Http\Controllers;

use App\Models\Sobrenome;
use Exception;
use Illuminate\Http\Request;

class SobrenomeController extends Controller
{
    public function index()
    {
        try {
            return Sobrenome::all();
        } catch (Exception $error) {
            return response("Erro ao listar os sobrenomes", 404);
        }
    }

    public function store(Sobrenome $sobrenome)
    {
        try {
            $sobrenome->save();
        } catch (Exception $error) {
            return response("Erro ao inserir o sobrenome", 404);
        }
    }
}
