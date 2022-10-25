<?php

namespace App\Http\Controllers;

use App\Http\Resources\VersiculosCollection;
use App\Http\Resources\VersiculosResource;
use App\Models\Versiculo;
use Illuminate\Http\Request;

class VersiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new VersiculosCollection(Versiculo::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Versiculo::create($request->all())){
            return response()->json([
                'mensagem' => 'Versiculo Inserido com Sucesso!'
            ],201);
        }

        return response()->json([
            'mensagem' => 'Erro ao Inserir Versiculo!'
        ],404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($versiculo)
    {
        $versiculo = Versiculo::with('livro')->find($versiculo);

        if(isset($versiculo)){
            return new VersiculosResource($versiculo);
        }
        return response()->json([
            'mensagem' => 'Versiculo não encontardo!'
        ], 404);
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
        $versiculo = Versiculo::find($id);

        if(isset($versiculo)){
            $versiculo->livro;
            return $versiculo;
        }

        return response()->json([
            'mensagem' => 'Erro, não conseguimos atualizar Versiculo!'
        ],404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Versiculo::destroy($id)){
            return response()->json([
                'mensagem' => 'Versiculo Excluido com Sucesso!'
            ], 201);
        }
        return response()->json([
            'mensagem' => 'Versiculo não encontrado!'
        ], 404);
    }
}
