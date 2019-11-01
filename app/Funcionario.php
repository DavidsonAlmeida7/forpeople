<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    static function validarCpf($cpf) {
        return Funcionario::select('*')->where('cpf', '=', $cpf)->get()->toArray();
    }
    # Retorna todos os funcionario
    static function getTodosFuncionarios() {
        return ['data' => Funcionario::paginate()];
    }
    # Retorna funcionario especifico
    static function getFuncionariosEspecifico($id) {
        return ['data' => Funcionario::where('id', $id)->paginate()];
    }
}



