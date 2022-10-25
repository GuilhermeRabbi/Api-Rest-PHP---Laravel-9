<?php

namespace App\Http\Controllers;

use App\Http\Resources\TestamentoCollection;
use App\Http\Resources\TestamentoResource;
use App\Models\Testamento;
use Illuminate\Http\Request;

class TestamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new TestamentoCollection(Testamento::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Testamento::create($request->all())){
            return response()->json([
                'mensagem' => 'Testamento Criado com Sucesso!'
            ],201);
        }
        return response()->json([
            'mensagem' => 'Erro ao Cadastar Testamento!'

        ],404);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($testamento)
    {
        $testamento = Testamento::with('livros')->find($testamento);
        if(isset($testamento)){
            return new TestamentoResource($testamento);
        }

        return response()->json([
            'mensagem' => 'Erro, não conseguimos localizar o testamento!'
        ],404);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $testamento)
    {
        $testamento = Testamento::find($testamento);
        if(isset($testamento)){
            $testamento->update($request->all());
            return $testamento;
        }

        return response()->json([
            'mensagem' => 'Erro ao Atualizar Testamento!'
        ],404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $testamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($testamento)
    {
        if(Testamento::destroy($testamento)){
            return response()->json([
                'mensagem' => 'Testamento Excluido com Sucesso!'
            ],201);
        }

        return response()->json([
            'mensagem' => 'Erro ao Excluir Testamento!'
        ],404);

    }
}
