<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Repositories\CategoriaRepository;

class CategoriaController extends Controller
{
    public function __construct(Categoria $categoria){

        $this->categoria = $categoria;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categoriaRepository= new CategoriaRepository($this->categoria); 

        if($request->has('filtro')){

            $filtros = explode(';', $request->filtro);

            foreach($filtros as $chave => $condicao){

                $valoresFiltro = explode(':', $condicao);

                $categoriaRepository->filtro($valoresFiltro[0], $valoresFiltro[1], $valoresFiltro[2]);
                
            }
        }
        if($request->has('atributos')){
    
            $categoriaRepository->selectAtributos($request->atributos);
                                                  
        }
        if($request->has('relacoes')){

            $relacoes = explode(';', $request->relacoes);

            $categoriaRepository->registrosRelacionados($relacoes);

        }
        $categorias = ($request->has('filtro')) ? 
            $categoriaRepository->getResultado() : $categoriaRepository->resultadoPaginado($totalPorPagina = 20);
    
            if(count($categorias) == 0){
    
                return Response([], 404);
            }
    
            return Response()->json($categorias, 200);
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
        $regras = $this->categoria->regras();
        $feedBack = $this->categoria->feedBack();

        $request->validate($regras, $feedBack);

        if($this->categoria->create($request->all())){

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
        $categoria = $this->categoria->find($id);

        if($categoria){

            return Response()->json($categoria->toArray(), 200);
        }

        return Response(['msg' => 'Falha ao encontrar categoria'], 500);
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
        $categoria = $this->categoria->find($id);

        if($categoria){

            $valores = $request->all();

            $regras = $this->categoria->regras($valores);
            $feedBack = $this->categoria->feedBack();

            $request->validate($regras, $feedBack);

            if($categoria->update($valores)){

                $categoria = $this->categoria->find($id);

                return Response()->json($categoria->toArray(), 200);
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
    public function destroy($id)
    {
        $categoria = $this->categoria->find($id);

        if($categoria){

            $categoria->delete();

            return Response()->json(['msg' => 'Categoria removida com sucesso'], 200);
        }

        return Response(['msg' => 'Falha ao remover produto'], 500);
    }
}
