<?php

namespace App\Http\Controllers;

use App\Http\Resources\VersaoResource;
use App\Http\Resources\VersoesCollection;
use App\Models\Versao;
use Illuminate\Http\Request;

class VersaoController extends Controller
{

    public function index()
    {
        return new VersoesCollection(Versao::select('id', 'nome', 'abreviacao')->paginate(5));
    }

    public function store(Request $request)
    {
        if(Versao::create($request->all())){
            return response()->json([
                'mensagem' => 'Versão Criada com Sucesso!'
            ], 201);
        }
        return response()->json([
            'mensagem' => 'Não foi possivel inserir Versão'
        ],404);
    }


    public function show($versao)
    {
        $versao = Versao::with('idioma','livros')->find($versao);
        if(isset($versao)){
            return new VersaoResource($versao);
        }
        return response()->json([
            'mensagem' => 'Não foi localizado a Versão'
        ], 404);
    }


    public function update(Request $request, $versao)
    {
        $versao = Versao::find($versao);
        if(isset($versao)){
            $versao->update($request->all());
            return $versao;
        }
        return response()->json([
            'mensagem' => 'Versão não localizado!'
        ], 404);
    }


    public function destroy($versao)
    {
        if(Versao::destroy($versao)){
            return response()->json([
                'mensagem' => 'Versão excluido com Sucesso!'
            ], 201);
        }
        return response()->json([
            'mensagem' => 'Erro! Não foi possivel excluir Versão!'
        ],404);
    }
}
