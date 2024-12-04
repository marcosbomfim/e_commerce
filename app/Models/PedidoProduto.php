<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Thiagoprz\CompositeKey\HasCompositeKey;
use App\Rules\PedidoProdutoRule;
use App\Rules\PagamentoRule;

class PedidoProduto extends Model
{
    use HasCompositeKey;
    protected $table = 'pedidos_produtos';
    protected $primaryKey = ['pedido_id', 'produto_id'];
    protected $fillable = ['pedido_id', 'produto_id', 'quantidade'];

    public function regras($custom = []){

        $pedido_id = isset($custom['pedido_id']) ? $custom['pedido_id'] : null;
        $produto_id = isset($custom['produto_id']) ? $custom['produto_id'] : null;

        $regras = [
            'pedido_id' => array("required", "exists:App\Models\Pedido,id"),
            'produto_id' => array("required", "exists:App\Models\Produto,id"),
            'quantidade' => array("required", "numeric", "min:1", "max:11"),
            'update' => array(new PedidoProdutoRule($pedido_id, $produto_id)),
            'delete'=>array(new PagamentoRule)
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
            'pedido_id.exists' => 'Não existe um pedido com o id informado',
            'produto_id.exists' => 'Não existe um produto com o id informado',
            'quantidade.max' => 'Valor acima do limite de 11 digitos',
            'quantidade.min' => 'Seleciona ao menos 1 produto',
            ];
    }

}
