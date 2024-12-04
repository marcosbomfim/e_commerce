<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

class AbstractRepository
{

    public function __construct(Model $model){

        $this->model = $model;
    }

    public function filtro($campo, $op, $val){

        if(strnatcasecmp($op, 'like') == 0){

            $val = '%'.$val.'%';
        }

        $this->model = $this->model->where($campo, $op, $val);

        return $this;
    }

    public function registrosRelacionados(Array $relacoes){

        foreach($relacoes as $chave => $valor){

            $this->model = $this->model->with($valor);

        }
        return $this;
    }

    public function resultadoPaginado($totalPorPagina){
        return $this->model->get();
        $total = $this->model->get();

        // if(count($total) <= 20){

        //     return $this->model->get();
        // }

        return $this->model->paginate($totalPorPagina);

    }

    public function selectAtributos($atributos){

        $this->model = $this->model->selectRaw($atributos);
        
        return $this;
    }

    public function getResultado(){

        return $this->model->get();
    }

    public function find($id){

        return $this->model->find($id);
    }

}