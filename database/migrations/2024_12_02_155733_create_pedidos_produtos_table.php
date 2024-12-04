<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos_produtos', function (Blueprint $table) {
            $table->timestamps();
            $table->integer('quantidade');
            $table->unsignedBigInteger('pedido_id');
            $table->unsignedBigInteger('produto_id');

            $table->foreign('pedido_id')->references('id')->on('pedidos');
            $table->foreign('produto_id')->references('id')->on('produtos');
            $table->primary(['pedido_id', 'produto_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pedidos_produtos');
        Schema::enableForeignKeyConstraints();
        
    }
}
