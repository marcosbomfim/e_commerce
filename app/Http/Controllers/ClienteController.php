<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;

class ClienteController extends Controller
{
    public function __construct(Cliente $cliente){

        $this->cliente = $cliente;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository= new ClienteRepository($this->cliente); 

        if($request->has('filtro')){

            $filtros = explode(';', $request->filtro);

            foreach($filtros as $chave => $condicao){

                $valoresFiltro = explode(':', $condicao);

                $clienteRepository->filtro($valoresFiltro[0], $valoresFiltro[1], $valoresFiltro[2]);
                
            }
        }
        if($request->has('atributos')){
    
            $clienteRepository->selectAtributos($request->atributos);
                                                  
        }
        if($request->has('relacoes')){

            $relacoes = explode(';', $request->relacoes);

            $clienteRepository->registrosRelacionados($relacoes);

        }
        $clientes = $clienteRepository->getResultado(); 

        if(count($clientes) == 0){

            return Response([], 404);
        }

        return Response()->json($clientes, 200);
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
        $regras = $this->cliente->regras();
        $feedBack = $this->cliente->feedBack();

        $request->validate($regras, $feedBack);

        if($this->cliente->create($request->all())){

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
        $cliente = $this->cliente->find($id);

        if($cliente){

            return Response()->json($cliente->toArray(), 200);
        }

        return Response(['msg' => 'Falha ao encontrar cliente'], 500);
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
        $cliente = $this->cliente->find($id);

        if($cliente){

            $valores = $request->all();

            $cpf = ($request->has('cpf')) ? $request->cpf : null;

            $regras = $this->cliente->regras($valores, $ignoreCPF = $cpf);
            $feedBack = $this->cliente->feedBack();

            $request->validate($regras, $feedBack);

            if($cliente->update($valores)){

                $cliente = $this->cliente->find($id);

                return Response()->json($cliente->toArray(), 200);
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
        $cliente = $this->cliente->find($id);

        if($cliente){

            $cliente->delete();

            return Response()->json(['msg' => 'Cliente removido com sucesso'], 200);
        }

        return Response(['msg' => 'Falha ao remover cliente'], 500);
    }
}
