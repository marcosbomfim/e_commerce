<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagamento extends Model
{
    use HasFactory;
    protected $table = 'pagamentos';
    protected $fillable = ['pedido_id', 'total', 'forma_pagamento'];

    public function pedido(){

        return $this->BelongsTo('App\Models\Pedido');
    }

    public function regras(){

        return  [
            'pedido_id' =>array("required", "exists:App\Models\Pedido,id"),
            'total'=> array("required", "numeric"),
            'forma_pagamento' => array("required", "max:150")  
        ];

    }
    public function feedback(){

        return  [
            'required' => 'O campo :attribute não pode ser vazio',
            'total.numeric' => 'Valor inválido',
            'forma_pagamento.max' => "A forma de pagamento não pode ser maior que 150 caracteres",
            'pedido_id.exists' => 'Não existe um pedido com o id informado',
        ];
    }
}
