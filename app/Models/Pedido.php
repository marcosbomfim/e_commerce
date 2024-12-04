<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table = 'pedidos';
    protected $fillable = ['cliente_id'];

    public function cliente(){

        return $this->belongsTo('App\Models\Cliente');
    }
    public function pagamento(){

        return $this->hasMany('App\Models\Pagamento');
    }
    public function produto(){

        return $this->belongsToMany('App\Models\Produto', 'pedidos_produtos');
    }

    public function regras(){

        return  [
            'cliente_id' =>array("required", "exists:App\Models\Cliente,id"),
            
        ];

    }
    public function feedback(){

        return  [
            'required' => 'O campo :attribute não pode ser vazio',
            'cliente_id.exists' => 'Não existe um cliente com o id infomado',
            ];
    }
   
    
}
