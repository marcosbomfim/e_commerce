# Sistema de e_commerce API Rest utilizando Laravel

<h1>Documentação</h1>
<h2>Url Base - localhost:8000</h2>
<h3>Endpoints: cliente, pedido, produto, padidoProduto, categoria, pagamento
<h3>Clientes - GET </h3>
Endpoint: /cliente
<h5>Retorno - 200, 500</h5> 
  
Retorna todos os clientes

<h3>Clientes - POST </h3>
Endpoint: /cliente
<h5>Body</h5>
nome: String,
email: String,
cpf: String (Somente Numeros),
data_nascimento: String (aaaa-mm-dd)

<h5>Retorno - 201, 422, 500</h5> 
Retora o cliente criado

<h3>Clientes - GET </h3>
Endpoint: /cliente?params
Parametros: filtro, atributos, realacoes
<h5>Exemplo: /cliente?filtro=nome:like:Marcos Bomfim&atributos=id,nome,cpf&relacoes=pedido</h5>
<h5>Retorno - 200, 500</h5> 
Retora os clientes e as tabelas relacionadas de acordo com o filtro estabelecido.

<h3>Clientes - UPDATE </h3>
Endpoint: /cliente/{id}
<h5>Exemplo: /cliente/1</h5>
<h5>Body - Enviar os valores que serão alterados</h5>
nome_produto: String,
valor: decimal
<h5>Retorno - 201, 422, 500</h5> 

<h3>Clientes - DELETE </h3>
Endpoint: /cliente/{id}
<h5>Exemplo: /cliente/1</h5>
<h5>Retorno - 201, 422, 500</h5> 
Retora mensagem de confirmação
<p></p>
<p>------------------------------------------------------------------</p>

<h3>Produtos - GET </h3>
Endpoint: /produto
<h5>Retorno - 200, 500</h5> 
  
Retorna todos os produtos

<h3>Produtos - POST </h3>
Endpoint: /produtos
<h5>Body</h5>
nome_produto: String,
valor: decimal,
total_estoque: Int,
categoria_id: Int(fk)

<h5>Retorno - 201, 422, 500</h5> 
Retora o produto criado

<h3>Produtos - GET </h3>
Endpoint: /produto?params
Parametros: filtro, atributos, realacoes
<h5>Exemplo: /produto?filtro=nome_produto:like:Guarda Roupa&atributos=id,nome_produto, categoria_id&relacoes=categoria</h5>
<h5>Retorno - 200, 500</h5> 
Retora os produtos e tabelas relacionados de acordo com o filtro estabelecido.

<h3>Produtos - UPDATE </h3>
Endpoint: /produto/{id}
<h5>Exemplo: /produto/1</h5>
<h5>Body - Enviar os valores que serão alterados</h5>
nome_produto: String,
valor: decimal
<h5>Retorno - 201, 422, 500</h5> 

<h3>Produtos - DELETE </h3>
Endpoint: /produto/{id}
<h5>Exemplo: /produto/1</h5>
<h5>Retorno - 201, 422, 500</h5> 
Retora mensagem de confirmação
<p></p>
<h1>Demais endpoints seguem a mesma logica de requisição</h1>

