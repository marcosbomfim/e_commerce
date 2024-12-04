<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PedidoProduto;

class PedidoProdutoController extends Controller
{
    public function __construct(PedidoProduto $pedidoProduto){

        $this->pedidoProduto = $pedidoProduto;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pedidoProduto = $this->pedidoProduto->all();

        if($pedidoProduto){

            return Response()->json($pedidoProduto->toArray(), 200);

        }else{

            return Response([], 404);
        }
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
        $regras = $this->pedidoProduto->regras();
        $feedBack = $this->pedidoProduto->feedBack();

        $request->validate($regras, $feedBack);

        if($this->pedidoProduto->create($request->all())){

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
        $pedidoProduto = $this->getIdComposto($id);

        if($pedidoProduto){

            return Response()->json($pedidoProduto->toArray(), 200);

        }else{

            return Response([], 404);
        }
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
     
   
        $pedidoProduto = $this->getIdComposto($id);

        if($pedidoProduto){

            $request['update'] = true;
           
            $regras = $this->pedidoProduto->regras($request->all());
            $feedBack = $this->pedidoProduto->feedBack();

            $request->validate($regras, $feedBack);

            if($pedidoProduto->update($valores)){

                $pedidoProduto = $this->pedidoProduto->find($id);

                return Response()->json($pedidoProduto->toArray(), 200);
            }

        }

        return Response(['msg' => 'Falha ao atualizar produtos do pedido'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $pedidoProduto = $this->getIdComposto($id);

        if($pedidoProduto){
            
            $request['delete'] = $request['pedido_id'];
            $regras = $this->pedidoProduto->regras($request->all());
            $feedBack = $this->pedidoProduto->feedBack();

            $request->validate($regras, $feedBack);

            $pedidoProduto->delete();

            return Response()->json(['msg' => 'Produto removido do pedido com sucesso'], 200);

        }else{
            return Response(['msg' => 'Pedido ou produto não encontrado'], 404);
        }

        
    }

    public function getIdComposto($id){

        $idComposto = str_split($id,  $length = 1);

        $pedido_id = (int)$idComposto[0];
        $produto_id = (int)$idComposto[1];

        $pedidoProduto = $this->pedidoProduto->find([$pedido_id, $produto_id]);

        return $pedidoProduto;
    }
}
