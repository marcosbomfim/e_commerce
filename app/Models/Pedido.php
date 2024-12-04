<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\PedidoRule;

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

    public function regras($custom = []){

        $regras = [
            'cliente_id' =>array("required", "exists:App\Models\Cliente,id"),
            'remocao' => array(new PedidoRule)
            
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
            'cliente_id.exists' => 'Não existe um cliente com o id infomado',
            ];
    }
   
    
}
