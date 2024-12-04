<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoProduto extends Model
{
    use HasFactory;
    protected $table = 'pedidos_produtos';
    protected $fillable = ['pedido_id', 'produto_id', 'quantidade'];

    public function regras(){

        return  [
            'pedido_id' =>array("required", "exists:App\Models\Pedido,id"),
            'produto_id' =>array("required", "exists:App\Models\Produto,id"),
            'quantidade' =>array("required", "numeric", "min:1", "max:11"),
        ];

    }
    public function feedback(){

        return  [
            'required' => 'O campo :attribute não pode ser vazio',
            'pedido_id.exists' => 'Não existe um pedido com o id informado',
            'produto_id.exists' => 'Não existe um produto com o id informado',
            'quantidade.max' => 'Valor acima do limite de 11 digitos',
            'quantidade.min' => 'Seleciona ao menos 1 produto'
            ];
    }

}
