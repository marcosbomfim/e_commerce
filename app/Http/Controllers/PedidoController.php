<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Repositories\PedidoRepository;

class PedidoController extends Controller
{
    public function __construct(Pedido $pedido){

        $this->pedido = $pedido;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pedidoRepository= new PedidoRepository($this->pedido); 

        if($request->has('filtro')){

            $filtros = explode(';', $request->filtro);

            foreach($filtros as $chave => $condicao){

                $valoresFiltro = explode(':', $condicao);

                $pedidoRepository->filtro($valoresFiltro[0], $valoresFiltro[1], $valoresFiltro[2]);
                
            }
        }
        if($request->has('atributos')){
    
            $pedidoRepository->selectAtributos($request->atributos);
                                                  
        }
        if($request->has('relacoes')){

            $relacoes = explode(';', $request->relacoes);

            $pedidoRepository->registrosRelacionados($relacoes);

        }
        $pedidos = ($request->has('filtro')) ? 
            $pedidoRepository->getResultado() : $pedidoRepository->resultadoPaginado($totalPorPagina = 20);
    
            if(count($pedidos) == 0){
    
                return Response([], 404);
            }
    
            return Response()->json($pedidos, 200);
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
        $regras = $this->pedido->regras();
        $feedBack = $this->pedido->feedBack();

        $request->validate($regras, $feedBack);

        if($this->pedido->create($request->all())){

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
        //
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
       
          return Response('Ação proibida', 401);
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

        $regras = $this->pedido->regras($request->all());

        $feedBack = $this->pedido->feedBack();

        $request->validate($regras, $feedBack);

        $pedido = $this->pedido->find($id);

        if($pedido){

            $pedido->delete();

            return Response()->json(['msg' => 'Pedido removido com sucesso'], 200);
        }

        return Response(['msg' => 'Falha ao remover pedido'], 500);
    }
}
