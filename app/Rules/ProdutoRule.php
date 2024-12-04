<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\PedidoProduto;


class ProdutoRule implements Rule
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
        $pedidoProduto = PedidoProduto::where('pedido_id', $value)->get()->toArray();
     
        if(count($pedidoProduto) > 0){

            $this->msg = 'Existem pedidos associados a esse produto, não é possivél remover';

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
