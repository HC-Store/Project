<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Produtos</title>
    <link rel="stylesheet" href="../src/assets/css/pagina-produto.css">
    <script src="../src/assets/js/produto-galeria.js" defer></script>
</head>
<body>
    <header>
        <div class="container">
        <input type="text" placeholder="O que você deseja ?">
        <img class="logo" src="/src/assets/image/logo da loja.svg" alt="logo loja">
        <nav class="icons">
            <a href=""><img src="/src/assets/image/Coração.svg" alt="coraçao"></a>
            <a href=""><img src="/src/assets/image/Sacola.svg" alt="Sacola"></a>
            <a href=""><img src="/src/assets/image/Login.svg" alt="login"></a>
        </nav>
      </div>
    </header>
    <section class="produto">
  <div class="produto-imagem">
    <img src="../src/assets/image/modelo.svg.svg" alt="Camiseta Empório Armani EA7">
  </div>

  <div class="detalhes">
    <h2>CAMISETA EMPÓRIO ARMANI EA7</h2>
    <p class="preco"><strong>R$99,99</strong></p>

    <!-- Seleção cor -->
    <h3>COR</h3>
    <div class="color-dots">
      <span class="dot azul" title="Azul"></span>
      <span class="dot branco" title="Branco"></span>
    </div>

    <!-- Seleção Tamanho -->
    <h3>TAMANHO</h3>
    <label><input type="radio" name="tamanho" value="P"> P</label>
    <label><input type="radio" name="tamanho" value="M"> M</label>
    <label><input type="radio" name="tamanho" value="G"> G</label>
    <label><input type="radio" name="tamanho" value="GG"> GG</label>
    <label><input type="radio" name="tamanho" value="XL"> XL</label>

    <!-- Botões Compra -->
    <div class="acoes">
      <button class="btn-carrinho">Adicionar ao Carrinho</button>
      <button class="btn-favorito"><img src="../src/assets/image/Coração.svg" alt="Lista de desejo" width="18"></button>
    </div>
    <button class="btn-comprar">Comprar</button>

    <!-- Sobre Produto -->
    <h3>Sobre Produto:</h3>
    <div class="descricao">
  <p> Camiseta EA7 masculina em tom vermelho vibrante, confeccionada em 100% algodão de alta qualidade, 
  proporcionando conforto e leveza para o uso diário.</p>
  <p>Apresenta um corte clássico e ajustado, ideal para combinar com diferentes estilos, 
  desde looks esportivos até casuais.</p>
  <p>O destaque fica para o logo EA7 branco, estampado no peito, conferindo um toque de sofisticação
   esportiva e identificação com a marca.</p>
  <p>A peça possui gola redonda reforçada e costuras discretas que garantem durabilidade e acabamento premium. </p>
  <p>Perfeita para quem busca estilo, conforto e autenticidade em uma camiseta versátil e moderna.</p>
    </div>
  </div>
</section>

<!-- Miniaturas galeria -->
<section class="galeria">
  <div class="miniaturas">
    <article><img src="../src/assets/image/frente.svg.svg" alt="Frente"></article>
    <article><img src="../src/assets/image/lado.svg.svg" alt="Lado"></article>
    <article><img src="../src/assets/image/costas.svg.svg" alt="Costas"></article>
  </div>
</section>

<!-- Outros Produtos -->
<section class="relacionados">
  <h3>Você Também pode Gostar</h3>
  <div class="lista-relacionados">
    <article class="card-produto">
      <img src="../src/assets/image/conjunto.svg" alt="">
      <h4>Conjunto Moletom EA7</h4>
      <p>R$349,99</p>
      <button>Ver Mais</button>
    </article>

    <article class="card-produto">
      <img src="../src/assets/image/conjunto.svg" alt="">
      <h4>Blusa Moletom Puma</h4>
      <p>R$199,99</p>
      <button>Ver Mais</button>
    </article>

    <article class="card-produto">
      <img src="../src/assets/image/conjunto.svg" alt="">
      <h4>Conjunto Puma</h4>
      <p>R$349,99</p>
      <button>Ver Mais</button>
    </article>

    <article class="card-produto">
      <img src="../src/assets/image/conjunto.svg" alt="">
      <h4>Conjunto Gucci</h4>
      <p>R$349,99</p>
      <button>Ver Mais</button>
    </article>

    <article class="card-produto">
      <img src="../src/assets/image/conjunto.svg" alt="">
      <h4>Blusa Moletom EA7</h4>
      <p>R$199,99</p>
      <button>Ver Mais</button>
    </article>
  </div>
</section>

<!-- Banner -->
<div class="banner">
  <img src="" alt="Banner de Frete Grátis">
</div>

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