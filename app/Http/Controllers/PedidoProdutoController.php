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
        $pedidoProduto = $this->pedidoProduto->find($id);

        if($pedidoProduto){

            $valores = $request->all();

            $cpf = ($request->has('cpf')) ? $request->cpf : null;

            $regras = $this->pedidoProduto->regras($valores, $ignoreCPF = $cpf);
            $feedBack = $this->pedidoProduto->feedBack();

            $request->validate($regras, $feedBack);

            if($pedidoProduto->update($valores)){

                $pedidoProduto = $this->pedidoProduto->find($id);

                return Response()->json($pedidoProduto->toArray(), 200);
            }

        }

        return Response(['msg' => 'Falha ao encontrar cliente'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pedidoProduto = $this->pedidoProduto->find($id);

        if($pedidoProduto){

            $pedidoProduto->delete();

            return Response()->json(['msg' => 'Produtos removidos do pedido com sucesso'], 200);
        }

        return Response(['msg' => 'Falha ao remover produtos do pedido'], 500);
    }
}
