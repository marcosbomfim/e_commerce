<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\PedidoProduto;

class PedidoProdutoRule implements Rule
{
    private $msg;
    private $pedido_id;
    private $produto_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($pedido_id, $produto_id)
    {
        $this->pedido_id = $pedido_id;
        $this->produto_id = $produto_id;

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
     
        $pedidoProduto = PedidoProduto::find([$this->pedido_id, $this->produto_id]);
                                       
        if($pedidoProduto){

            $this->msg = 'Produto já adicionado para o pedido!';

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
