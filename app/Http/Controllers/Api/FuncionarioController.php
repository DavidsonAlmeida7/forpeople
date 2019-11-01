<?php

namespace App\Http\Controllers\Api;

use App\Funcionario;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        # Retorna todos os funcionario
        return Funcionario::getTodosFuncionarios();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $funcionario = new Funcionario;

        if (!empty($request->get('cpf')))  {
            if (strlen($request->get('cpf')) != 11) {
                return json_encode(
                    array(
                        'status' => 203, 
                        'informacoes' => 'Qauntidade de caractere invalida para CPF (somente numeros).',
                        'dados' => $request->get('cpf')
                    )
                );
            }

            $verificaFuncionario = $funcionario->validarCpf($request->get('cpf'));
            
            if (count($verificaFuncionario) > 0) {
                return json_encode(
                    array(
                        'status' => 203, 
                        'informacoes' => 'Já existe um funcionario com o CPF cadastrado.',
                        'dados' => $request->get('cpf')
                    )
                );
            } else {
                
                $listaErro = array();

                $listaErro[] = empty($request->get('nome'))          ? 'Nome não pode ser vazio.'          : '';
                $listaErro[] = empty($request->get('cpf'))           ? 'CPF não pode ser vazio.'           : '';
                $listaErro[] = empty($request->get('cargo'))         ? 'Cargo não pode ser vazio.'         : '';
                $listaErro[] = empty($request->get('data_admissao')) ? 'Data admissão não pode ser vazio.' : '';
                $listaErro[] = empty($request->get('genero'))        ? 'Genero não pode ser vazio.'        : '';

                $listaErro[] = empty($request->get('logradouro'))    ? 'Logradouro não pode ser vazio.'    : '';
                $listaErro[] = empty($request->get('cidade'))        ? 'Cidade não pode ser vazio.'        : '';
                $listaErro[] = empty($request->get('uf'))            ? 'UF não pode ser vazio.'            : '';
                $listaErro[] = empty($request->get('numero'))        ? 'Numero não pode ser vazio.'        : '';
                $listaErro[] = empty($request->get('bairro'))        ? 'Bairro não pode ser vazio.'        : '';
                $listaErro[] = empty($request->get('cep'))           ? 'CEP não pode ser vazio.'           : '';

                $dadosRetorno = $this->verificarCampos($listaErro);

                if ($dadosRetorno['valido'] == 1) {
     
                    $funcionario->nome           = $request->get('nome');
                    $funcionario->cpf            = $request->get('cpf');
                    $funcionario->cargo          = $request->get('cargo');
                    $funcionario->data_admissao  = date('Y-m-d H:i:s', strtotime($request->get('data_admissao')));
                    $funcionario->genero         = $request->get('genero');

                    $funcionario->logradouro = $request->get('logradouro');
                    $funcionario->cidade     = $request->get('cidade');
                    $funcionario->uf         = $request->get('uf');
                    $funcionario->numero     = $request->get('numero');
                    $funcionario->bairro     = $request->get('bairro');
                    $funcionario->cep        = $request->get('cep');
                    $funcionario->save();

                    return json_encode(
                        array(
                            'status' => 201, 
                            'informacoes' => 'Registro criado com sucesso.' 
                        )
                    );
                } else {
                    return json_encode(
                        array(
                            'status' => 203, 
                            'informacoes' => 'Não foi possivel cadastrar o funcionario.',
                            'dados' =>  $dadosRetorno['dadosErros']
                        )
                    );
                }
            }
            
        } else {
            return json_encode(
                array(
                    'status' => 203, 
                    'informacoes' => 'O CPF não foi informado.'
                )
            );
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Funcionario::getFuncionariosEspecifico($id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $funcionario = Funcionario::find($id);

            $funcionario->nome           = $request->get('nome');
            $funcionario->cpf            = $request->get('cpf');
            $funcionario->cargo          = $request->get('cargo');
            $funcionario->data_admissao  = date('Y-m-d H:i:s', strtotime($request->get('data_admissao')));
            $funcionario->uf             = $request->get('uf');

            $funcionario->logradouro = $request->get('logradouro');
            $funcionario->cidade     = $request->get('cidade');
            $funcionario->uf         = $request->get('uf');
            $funcionario->numero     = $request->get('numero');
            $funcionario->bairro     = $request->get('bairro');
            $funcionario->cep        = $request->get('cep');

            if(!$funcionario->save()) {
                return json_encode(
                    array(
                        'status' => 203, 
                        'informacoes' => 'Não foi possivel realizar a edição.'
                    )
                );
            } else {
                return json_encode(
                    array(
                        'status' => 200, 
                        'informacoes' => 'Edição realizada com sucesso.'
                    )
                );
            }
        
        } catch (\Exeption $e) {
            return response()->json(['msg' => 'Ops... Erro ao editar informação'], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            if(!Funcionario::where('id', $request->get('id'))->delete()) {
                return json_encode(
                    array(
                        'status' => 203, 
                        'informacoes' => 'ID não encontrado para exclusão.'
                    )
                );
            } else {
                return json_encode(
                    array(
                        'status' => 200, 
                        'informacoes' => 'Exclusão realizada com sucesso.'
                    )
                );
            }
        } catch (\Exeption $e) {
            return json_encode(['msg' => 'Ops... Erro ao excluir informação'], 500);
        }
    }

    private function verificarCampos($listaDados = array()) {

        $dadosRetorno = array();
        $dadosRetorno['valido'] = true;

        foreach ($listaDados as $chave => $valor) {
                    
            if(!empty($listaDados[$chave])) {
                $dadosRetorno['valido']     = false;
                $dadosRetorno['dadosErros'][] = $listaDados[$chave];
            }
        }
        return $dadosRetorno;
    }
}