<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Produto;

class CategoriaRule implements Rule
{

    private $msg;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        $produto = Produto::where('categoria_id', $value)->get()->toArray();

        if(count($produto) > 0){

            $this->msg = 'Existem produtos associados a essa categoria, não é possivél remover';

            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg; 
    }
}
