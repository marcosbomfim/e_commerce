<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\CategoriaRule;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = ['nome_categoria'];

    public function produto(){

        return $this->hasMany('App\Models\Produto');
    }

    public function regras($custom = []){

        $regras = [
            'nome_categoria' => array("required", "max:255"),
            'remocao' => array(new CategoriaRule)
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
            'nome_categoria.max' => 'O nome da categoria não pode ser maior que 255 caracteres',
            ];
    }
    
}
