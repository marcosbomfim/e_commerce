<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Repositories\ProdutoRepository;

class ProdutoController extends Controller
{
    public function __construct(Produto $produto){

        $this->produto = $produto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produtoRepository= new ProdutoRepository($this->produto); 

        if($request->has('filtro')){

            $filtros = explode(';', $request->filtro);

            foreach($filtros as $chave => $condicao){

                $valoresFiltro = explode(':', $condicao);

                $produtoRepository->filtro($valoresFiltro[0], $valoresFiltro[1], $valoresFiltro[2]);
                
            }
        }
        if($request->has('atributos')){
    
            $produtoRepository->selectAtributos($request->atributos);
                                                  
        }
        if($request->has('relacoes')){

            $relacoes = explode(';', $request->relacoes);

            $produtoRepository->registrosRelacionados($relacoes);

        }
        $produtos = ($request->has('filtro')) ? 
            $produtoRepository->getResultado() : $produtoRepository->resultadoPaginado($totalPorPagina = 20);
    
            if(count($produtos) == 0){
    
                return Response([], 404);
            }
    
            return Response()->json($produtos, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regras = $this->produto->regras();
        $feedBack = $this->produto->feedBack();

        $request->validate($regras, $feedBack);

        if($this->produto->create($request->all())){

            return Response()->json($request->all(), 201);
        }

        return Response(['msg' => 'Falha ao gravar dados'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produto = $this->produto->find($id);

        if($produto){

            return Response()->json($produto->toArray(), 200);
        }

        return Response(['msg' => 'Falha ao encontrar produto'], 500);
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
        $produto = $this->produto->find($id);

        if($produto){

            $valores = $request->all();

            $regras = $this->produto->regras($valores);
            $feedBack = $this->produto->feedBack();

            $request->validate($regras, $feedBack);

            if($produto->update($valores)){

                $produto = $this->produto->find($id);

                return Response()->json($produto->toArray(), 200);
            }

            
        }

        return Response(['msg' => 'Falha ao atualizar produto'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $request['remocao'] = $id;

        $regras = $this->produto->regras($request->all());

        $feedBack = $this->produto->feedBack();

        $request->validate($regras, $feedBack); //poderia utilizar validator tbm;

        $produto = $this->produto->find($id);

        if($produto){

            $produto->delete();

            return Response()->json(['msg' => 'Produto removido com sucesso'], 200);
        }

        return Response(['msg' => 'Falha ao remover produto'], 500);
    }
}
