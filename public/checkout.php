<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check-Out</title>
    <link rel="stylesheet" href="../src/assets/css/checkout.css">
</head>
<body>
    <header>
        <div class="container">
            <input type="text" placeholder="O que você deseja ?">
        <img src="/src/assets/image/logo da loja.svg" alt="logo loja">
        <nav class="icons">
            <a href=""><img src="/src/assets/image/Coração.svg" alt="coraçao"></a>
            <a href=""><img src="/src/assets/image/Sacola.svg" alt="Sacola"></a>
            <a href=""><img src="/src/assets/image/Login.svg" alt="login"></a>
        </nav> 
    </div>
    </header>
    <!--Informações de Contato -->
   <main class="checkout">
  <!-- Coluna esquerda -->
  <section class="checkout-esquerda">
    <form action="#" method="post" class="form checkout-left">
  <!-- Contato -->
  <h1 class="titulo">Contato</h1>
  <p class="section-subtitle">
    Usaremos essa forma de contato para manter você informado sobre o pedido
  </p>
  
  <label for="email">Digite seu Email*</label>
  <input type="email" id="email" name="email" required>

  <label for="telefone">Número de Telefone</label>
  <input type="tel" id="telefone" name="telefone" required>


  <!-- Endereço de Envio -->
  <h1 class="titulo">Endereço de Envio</h1>

  <div class="form-linha">
    <div>
      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" required>
    </div>
    <div>
      <label for="sobrenome">Sobrenome</label>
      <input type="text" id="sobrenome" name="sobrenome" required>
    </div>
  </div>

  <div class="form-linha">
    <div>
      <label for="cep">CEP</label>
      <input type="text" id="cep" name="cep" maxlength="8" required>
    </div>
    <div class="cep-btn">
      <button type="button" onclick="buscarCEP()">Buscar CEP</button>
    </div>
  </div>

  <label for="endereco">Endereço</label>
  <input type="text" id="endereco" name="endereco" readonly>

  <label for="bairro">Bairro</label>
  <input type="text" id="bairro" name="bairro" readonly>

  <label for="cidade">Cidade</label>
  <input type="text" id="cidade" name="cidade" readonly>

  <label for="estado">Estado</label>
  <input type="text" id="estado" name="estado" readonly>

  <div class="form-linha">
    <div>
      <label for="complemento">Apart ou Casa</label>
      <input type="text" id="complemento" name="complemento">
    </div>
    <div>
      <label for="numero">Número</label>
      <input type="number" id="numero" name="numero">
    </div>
  </div>

  <!-- Botão de envio -->
  <button >Finalizar Pedido</button>
</form>

  </section>

  <!-- Coluna direita -->
  <aside class="checkout-direita">
    <h2>Resumo do Pedido</h2>
    <div class="resumo-pedido">
      <p>1 ITEM <span>R$130,00</span></p>
      <p>Entrega <span>R$6,99</span></p>
      <p>Taxas <span>R$0,00</span></p>
      <p class="total"><strong>Total <span>R$136,99</span></strong></p>
    </div>

    <div class="detalhe">
      <img src="" alt="Tênis">
      <div>
        <h3>DROPSET TRAINER SHOES</h3>
        <p>Mens Road Running Shoes<br>Tamanho 42  Quantidade  1</p>
        <span>R$130,00</span>
      </div>
    </div>

    <div class="desconto">
      <input type="text" placeholder="Cupom de desconto">
      <button>Aplicar</button>
    </div>
  </aside>
</main>

<footer>
    <!-- Benefícios -->
<div class="beneficios-container">
<div class="beneficio">
<img src="./image/relogio-frete.svg"alt="Entrega">
<div class="texto">
<strong>Entrega expressa</strong>
<span>a partir de 1 dia útil</span>
</div>
</div>

<div class="beneficio">
<img src=""alt="Parcelamento">
<div class="texto">
<strong>Parcele em até 10x</strong>
<span>sem juros</span>
</div>
</div>
</div>

<!-- Seções -->
<div class="segunda-part">
<nav>
<h2 class="text">Ajuda</h2>
<a class="link" href="#">Trocas e Devoluções</a>
<a class="link" href="#">Entregas</a>
<a class="link" href="#">Minha Conta</a>
<a class="link" href="#">Meus Pedidos</a>
<a class="link" href="#">Pagamentos</a>
<a class="link"href="#">Cancelamentos</a>
</nav>

<nav>
<h2 class="text">Institucional</h2>
<a class="link" href="#">Sobre a Hc Store</a>
<a class="link" href="#">Nossa Loja</a>
<a class="link" href="#">Termos de Uso</a>
<a class="link"href="#">Privacidade</a>
</nav>

<nav>
<h2 class="text">Políticas</h2>
<a class="link"href="#">Regulamentos</a>
<a class="link" href="#">Política de Privacidade</a>
<a class="link" href="#">Segurança & Privacidade</a>
</nav>

<nav>
<h2 class="text">Central de Relacionamento</h2>
<a class="link" href="#">Tire suas dúvidas</a>
</nav>

<nav>
<h2 class="text">Fique por dentro das novidades</h2>
<div class="social-icons">
<a href="#"><img src="" alt="WhatsApp"></a>
<a href="#"><img src="" alt="Facebook"></a>
<a href="#"><img src="" alt="Instagram"></a>
<a href="#"><img src="" alt="TikTok"></a>
</div>
</nav>
</div>

<!-- Pagamento e App -->
<div class="rodape-final">
<div class="pagamento">
<img src="" alt="Formas de pagamento">
</div>
</footer>


</body>
</html>