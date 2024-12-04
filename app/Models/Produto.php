<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\ProdutoRule;

class Produto extends Model
{
    use HasFactory;
    protected $table = 'produtos';
    protected $fillable = ['nome_produto', 'valor', 'total_estoque'];

    public function pedido(){

        return $this->belongsToMany('App\Models\Pedido', 'pedidos_produtos');
    }
    public function categoria(){

        return $this->belongsTo('App\Models\Categoria');
    }

    public function regras($custom = []){

        $regras = [
            'nome_produto' =>array("required", "max:255"),
            'valor' => array("required", "numeric"),
            'total_estoque' => array("required" , "integer", "max:11"),
            'categoria_id' => array("required", "exists:App\Models\Categoria,id"),
            'remocao' => array(new ProdutoRule)
        ];

        if(count($custom)==0){

            return $regras;
        }

        $regrasCustom = [];

        foreach($custom as $chave=>$valor){

            if(array_key_exists($chave, $regras)){

                $regrasCustom[$chave]=$regras[$chave];
            }

        }
            
        return $regrasCustom;
    }
    public function feedback(){

        return  [
            'required' => 'O campo :attribute não pode ser vazio',
            'nome_produto.max' => 'O nome do produto não pode ultrapassar os 255 carácteres',
            'valor.numeric' => 'O valor deve ser um numero',
            'total_estoque.integer' => 'Valor digitado acima do limite',
            'categoria_id.exists' => 'Não existe uma categoria com o id informado',
            ];
    }
   
}
