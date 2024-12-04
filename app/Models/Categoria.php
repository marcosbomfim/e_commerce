<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'categorias';
    protected $fillable = ['nome_categoria'];

    public function produto(){

        return $this->hasMany('App\Models\Produto');
    }

    public function regras(){

        return  [
            'nome_categoria' =>array("required", "max:255"),
            
        ];

    }
    public function feedback(){

        return  [
            'required' => 'O campo :attribute não pode ser vazio',
            'nome_categoria.max' => 'O nome da categoria não pode ser maior que 255 caracteres',
            ];
    }
    
}
