<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pagamento;
use App\Repositories\PagamentoRepository;

class PagamentoController extends Controller
{
    public function __construct(Pagamento $pagamento){

        $this->pagamento = $pagamento;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagamentoRepository= new PagamentoRepository($this->pagamento); 

        if($request->has('filtro')){

            $filtros = explode(';', $request->filtro);

            foreach($filtros as $chave => $condicao){

                $valoresFiltro = explode(':', $condicao);

                $pagamentoRepository->filtro($valoresFiltro[0], $valoresFiltro[1], $valoresFiltro[2]);
                
            }
        }
        if($request->has('atributos')){
    
            $pagamentoRepository->selectAtributos($request->atributos);
                                                  
        }
        if($request->has('relacoes')){

            $relacoes = explode(';', $request->relacoes);

            $pagamentoRepository->registrosRelacionados($relacoes);

        }
        $pagamentos = ($request->has('filtro')) ? 
            $pagamentoRepository->getResultado() : $pagamentoRepository->resultadoPaginado($totalPorPagina = 20);
    
            if(count($pagamentos) == 0){
    
                return Response([], 404);
            }
    
            return Response()->json($pagamentos, 200);
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
        $regras = $this->pagamento->regras();
        $feedBack = $this->pagamento->feedBack();

        $request->validate($regras, $feedBack);

        if($this->pagamento->create($request->all())){

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
        $pagamento = $this->pagamento->find($id);

        if($pagamento){

            return Response()->json($pagamento->toArray(), 200);
        }

        return Response(['msg' => 'Falha ao encontrar pagamento'], 500);
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
        $pagamento = $this->pagamento->find($id);

        if($pagamento){

            $valores = $request->all();

            $regras = $this->pagamento->regras($valores);
            $feedBack = $this->pagamento->feedBack();

            $request->validate($regras, $feedBack);

            if($pagamento->update($valores)){

                $pagamento = $this->pagamento->find($id);

                return Response()->json($pagamento->toArray(), 200);
            }

            
        }

        return Response(['msg' => 'Falha ao atualizar pagamento'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pagamento = $this->pagamento->find($id);

        if($pagamento){

            $pagamento->delete();

            return Response()->json(['msg' => 'Dados de pagamento removido com sucesso'], 200);
        }

        return Response(['msg' => 'Falha ao remover dados de pagamento'], 500);
    }
}
