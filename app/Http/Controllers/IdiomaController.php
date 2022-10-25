<?php

namespace App\Http\Controllers;

use App\Http\Resources\IdiomaResource;
use App\Models\Idioma;
use Illuminate\Http\Request;

class IdiomaController extends Controller
{

    public function index()
    {
        return Idioma::all();
    }


    public function store(Request $request)
    {

        if(Idioma::create($request->all())){
            return response()->json([
                'mensagem' => 'Idioma Inserido com Sucesso!'
            ]);
        }
        return response()->json([
            'mensagem' => 'Erro! Idioma não inserido!'
        ], 404);
    }


    public function show($idioma)
    {
        $idioma = Idioma::with('versoes')->find($idioma);
        if(isset($idioma)){
            return new IdiomaResource($idioma);
        }
        return response()->json([
            'mensagem' => 'Idioma não Localizado'
        ], 404);
    }


    public function update(Request $request, $idioma)
    {
        $idioma = Idioma::find($idioma);
        if(isset($idioma)){
            $idioma->update($request->all());
            return $idioma;
        }

        return response()->json([
            'mensagem' => 'Não foi possivel atualizar idioma'
        ], 404);
    }


    public function destroy($idioma)
    {

        if(Idioma::destroy($idioma)){
            return response()->json([
                'mensagem' => 'Idioma Excluido com Sucesso!'
            ], 201);
        }
        return response()->json([
            'mensagem' => 'Erro! Falha ao excluir idioma!'
        ],404);
    }
}
