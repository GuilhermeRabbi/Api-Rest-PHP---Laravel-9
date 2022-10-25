<?php

namespace App\Http\Controllers;

use App\Http\Resources\LivrosCollection;
use App\Http\Resources\LivrosResource;
use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new LivrosCollection(Livro::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Livro::create($request->all())){
            return response()->json([
                'mensagem' => 'Livro Cadastrado com Sucesso!'
            ],201);
        }

        return response()->json([
            'mensagem' => 'Erro ao Cadastrar o Livro'
        ], 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($livro)
    {
        $livro = Livro::with('testamento', 'versiculos', 'versao')->find($livro);
        if(isset($livro)){

            return new LivrosResource($livro);
        }

        return response()->json([
            'mensagem' => 'Erro ao Pesquisar Livro'
        ],404);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $livro)
    {
        $path = $request->capa->store('capa_livro', 'public');
        $livro = Livro::find($livro);

        if(isset($livro)){
            $livro->capa = $path;

            if($livro->save()){
                return $livro;
            }else{
                return response()->json([
                    'mensagem' => 'Erro ao atualizar arquivo Livro'
                ],404);
            }
        }

        return response()->json([
            'mensagem' => 'Erro ao atualizar Livro!'
        ],404);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $livro
     * @return \Illuminate\Http\Response
     */
    public function destroy($livro)
    {

        if(Livro::destroy($livro)){
            return response()->json([
                'mensagem' => 'Livro Excluido com Sucesso!'
            ],201);
        }

        return response()->json([
            'mensagem' => 'Livro não localizado'
        ],404);

    }
}
