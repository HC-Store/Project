

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="../src/assets/css/header-public.css">
    <!-- CSS da página -->
    <link rel="stylesheet" href="../src/assets/css/home.css">
    
    <script src="../src/assets/js/header-public.js" defer></script>
    <!-- JS da página -->
    <script src="../src/assets/js/home-carrosel.js" defer></script>
</head>

<body>
  <?php 
  $mostrarMenu = true; 
  include_once("../src/includes/header-public.php"); 
?>

<!-- ========================== FAIXA PROMOCIONAL ============================ -->
<div class="promo-bar">
  <div class="promo-text">
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -  
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -  
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -
  </div>
</div>

<!-- ========================== BANNER PRINCIPAL ============================ -->
<section class="carousel" id="bannerCarousel">
  <div class="carousel-track" data-interval="4000">
    <div class="carousel-item active">
      <img src="../src/assets/image/banner1.svg" alt="Banner 1">
      <a href="lista-produtos.php" class="btn-acao banner-btn">Ver Produtos</a>
    </div>
    <div class="carousel-item">
      <img src="../src/assets/image/banner2.svg" alt="Banner 2">
      <a href="lista-produtos.php" class="btn-acao banner-btn">Ver Produtos</a>
    </div>
    <div class="carousel-item">
      <img src="../src/assets/image/banner00.png" alt="Banner 3">
      <a href="lista-produtos.php" class="btn-acao banner-btn">Ver Produtos</a>
    </div>
  </div>
</section>

<!-- ========================== MARCAS ============================ -->
<section class="carousel marcas" id="marcasCarousel">
  <h2>Navegação por Marcas</h2>
  <div class="carousel-track">
    <nav>
      <a href="lista-produtos.php"><img src="../src/assets/image/nike.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/puma.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/adidas.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/LV.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/lacoste.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/gucci.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/New Balance.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/balenciaga.svg"></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/EA7.svg"></a>
    </nav>
  </div>
</section>

<!-- BEST SELLERS (Carrossel) --> 
 <section class="carousel produtos" id="bestSellersCarousel"> 
  
 <h2>Best Sellers</h2> 
 
 <div class="carousel-viewport" aria-label="Carrossel de produtos"> 
   
   <ul class="product-list"> 
      <!-- Produtos (10 no total) --> 
       <li class="product-card"> 
        <button class="fav" aria-label="Favoritar">♥</button> 
       <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/moletom-nike.jpg" alt="Moletom Nike"> 
      </a> 
       <h3 class="title">MOLETOM NIKE</h3> 
       <strong class="price">R$ 189,99</strong> 
       <button class="btn">Adicionar ao Carrinho</button> 
      </li> 
      
      <li class="product-card"> 
        <button class="fav" aria-label="Favoritar">♥</button> 
        <a href="pagina-produto.php" class="thumb"> <img src="../src/assets/image/shorts-nike.jpg" alt="Shorts Nike"> </a> 
        <h3 class="title">SHORTS NIKE</h3> 
        <strong class="price">R$ 120,00</strong> 
        <button class="btn">Adicionar ao Carrinho</button> 
      </li> 
      
      <li class="product-card"> 
        <button class="fav" aria-label="Favoritar">♥</button> 
        <a href="pagina-produto.php" class="thumb"> 
          <img src="../src/assets/image/tenis-nike.jpg" alt="Tênis Nike"> 
        </a> 
        <h3 class="title">TÊNIS NIKE</h3> 
        <strong class="price">R$ 349,90</strong> 
        <button class="btn">Adicionar ao Carrinho</button> 
      </li> 
      
      <li class="product-card"> 
        <button class="fav" aria-label="Favoritar">♥</button> 
        <a href="pagina-produto.php" class="thumb"> 
          <img src="../src/assets/image/sueter-adidas.jpg" alt="Suéter Adidas"> 
        </a>
       <h3 class="title">SUÉTER ADIDAS</h3> 
        <strong class="price">R$ 189,99</strong> 
        <button class="btn">Adicionar ao Carrinho</button> 
      </li> 
    <li class="product-card"> 
      <button class="fav" aria-label="Favoritar">♥</button> 
      <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/camiseta-puma.jpg" alt="Camiseta Puma"> 
      </a> 
      <h3 class="title">CAMISETA PUMA</h3> 
      <strong class="price">R$ 159,99</strong> 
      <button class="btn">Adicionar ao Carrinho</button> 
    </li> 
    
    <li class="product-card"> 
      <button class="fav" aria-label="Favoritar">♥</button> 
      <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/bolsa-lv.jpg" alt="Bolsa LV"> 
      </a> 
      <h3 class="title">BOLSA LV</h3> 
      <strong class="price">R$ 799,90</strong> 
      <button class="btn">Adicionar ao Carrinho</button> 
    </li> 
    
    <li class="product-card"> 
      <button class="fav" aria-label="Favoritar">♥</button> 
      <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/relogio-lacoste.jpg" alt="Relógio Lacoste"> 
      </a> 
      <h3 class="title">RELÓGIO LACOSTE</h3> 
      <strong class="price">R$ 499,99</strong> 
      <button class="btn">Adicionar ao Carrinho</button> 
    </li> 
    
    <li class="product-card"> 
      <button class="fav" aria-label="Favoritar">♥</button> 
      <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/pulseira-gucci.jpg" alt="Pulseira Gucci"> 
      </a> 
      <h3 class="title">PULSEIRA GUCCI</h3> 
      <strong class="price">R$ 299,99</strong> 
      <button class="btn">Adicionar ao Carrinho</button> 
    </li> 
    
    <li class="product-card"> 
      <button class="fav" aria-label="Favoritar">♥</button> 
      <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/carteira-balenciaga.jpg" alt="Carteira Balenciaga"> 
      </a> 
      <h3 class="title">CARTEIRA BALENCIAGA</h3> 
      <strong class="price">R$ 399,99</strong> 
      <button class="btn">Adicionar ao Carrinho</button> 
    </li> 
    
    <li class="product-card"> 
      <button class="fav" aria-label="Favoritar">♥</button> 
      <a href="pagina-produto.php" class="thumb"> 
        <img src="../src/assets/image/conjunto-ea7.jpg" alt="Conjunto EA7"> 
      </a> 
      <h3 class="title">CONJUNTO EA7</h3> 
      <strong class="price">R$ 249,99</strong> 
      <button class="btn">Adicionar ao Carrinho</button> 
    </li> 
  </ul> 
</div> 
</section>

<!-- ========================== BANNER ACESSÓRIOS ============================ -->
<section class="acess-bloco">
  <img class="acess-img" src="../src/assets/image/banner-acessorio.svg" alt="Acessórios">
  <div class="acess-txt">
    <h1 class="acess-titulo">O UNIVERSO<br>DOS<br>ACESSÓRIOS</h1>
    <p class="acess-sub">Peças atemporais e modernas<br>que definem a sua identidade.</p>
    <a href="lista-produtos.php" class="acess-btn">VER PRODUTOS</a>
  </div>
</section>

<!-- ========================== COMPLETE O LOOK ============================ -->
<section class="carrossel-look">
  <h2>Complete o Seu Look</h2>

  <div class="carrossel-container1">
    <div class="carrossel-track1">
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/bag.svg"></a></div>
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/relogio.svg"></a></div>
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/shorts (2).svg"></a></div>
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/sueter.svg"></a></div>
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/tennis_NIkE.svg"></a></div>
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/camiseta_puma.svg"></a></div>
      <div class="item"><a href="pagina-produto.php"><img src="../src/assets/image/conjunto (2).svg"></a></div>
    </div>
  </div>
</section>

<!-- ========================== BANNER FINAL ============================ -->
<section class="essencia-bloco">
  <img class="essencia-img" src="../src/assets/image/banner3.svg" alt="essencia">
  <div class="essencia-texto">
    <h1 class="essencia-titulo">
      VISTA O <br> QUE <br> COMBINA <br> COM A <br> SUA <br> ESSÊNCIA.
    </h1>
    <a href="lista-produtos.php" class="acess-btn">VER PRODUTOS</a>
  </div>
</section>

<footer>
    <!-- Benefícios -->
<div class="beneficios-container">
<div class="beneficio">
<img src="../src/assets/image/entrega.svg"alt="Entrega">
<div class="texto">
<strong>Entrega expressa</strong>
<span>a partir de 1 dia útil</span>
</div>
</div>

<div class="beneficio">
<img src="../src/assets/image/parcela.svg"alt="Parcelamento">
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
<a href="#"><img src="../src/assets/image/whats.svg" alt="WhatsApp"></a>
<a href="#"><img src="../src/assets/image/facebook.svg" alt="Facebook"></a>
<a href="#"><img src="../src/assets/image/instagram.svg" alt="Instagram"></a>
<a href="#"><img src="../src/assets/image/tiktok.svg" alt="TikTok"></a>
</div>
</nav>
</div>

<!-- Pagamento e App -->
<div class="rodape-final">
<div class="pagamento">
<img src="../src/assets/image/img-pagamento.svg" alt="Formas de pagamento">
</div>
</footer>

</body>
</html>