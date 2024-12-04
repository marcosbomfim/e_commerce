<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\CpfRule;
use Illuminate\Validation\Rule;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';
    protected $fillable = ['cpf', 'nome', 'email', 'data_nascimento'];

    public function pedido(){

        return $this->hasMany('App\Models\Pedido');
    }
    

    public function regras($custom = [], $cpf = null){

        $regras = [
            'cpf' =>array("required", Rule::unique('clientes')->ignore($cpf, 'cpf'), new CpfRule),
            'nome' =>array("required", "regex:/^[a-zA-Zà-úÀ-Ú ]+$/", "max:255", "min:8"),
            'email' => array("required", "email:rfc,dns"),
            'data_nascimento' => 'required|regex:/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/',
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
            'data_nascimento.regex' => 'O campo data de nascimento inválido',
            'name.regex' => 'Nome digitado é inválido',
            'cpf.unique' => 'Já existe um usuário com o CPF informado!',
            'email.email' => 'O campo email é inválido',
            ];
    }
}
