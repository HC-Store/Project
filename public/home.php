<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../src/assets/css/home.css">
    <script src="../src/assets/js/home-carrosel.js" defer></script>
</head>
<body>
  <header>
  <div class="container">
    <input type="text" placeholder="O que você deseja ?">
    <img src="../src/assets/image/logo.svg" alt="Logo">

    <nav class="icons">
      <!-- ❤️ FAVORITOS -->
      <div class="user-menu">
        <button class="icon-btn" id="fav-icon">
          <img src="../src/assets/image/Coração.svg" alt="Favoritos">
        </button>
        <div class="dropdown-panel" id="fav-dropdown">
          <h3>FAVORITOS</h3>
          <div class="conteudo-fav">
            <div class="produto-exemplo">
              <img src="" alt="Produto">
              <div class="produto-info">
                <strong>Camiseta Nike</strong>
                <span>R$ 149,99</span>
              </div>
            </div>
          </div>
          <button class="btn-acao">CONTINUAR COMPRANDO</button>
        </div>
      </div>

      <!-- 🛍️ SACOLA -->
      <div class="user-menu">
        <button class="icon-btn" id="bag-icon">
          <img src="../src/assets/image/Sacola.svg" alt="Sacola">
        </button>
        <div class="dropdown-panel" id="bag-dropdown">
          <h3>MINHA SACOLA (1)</h3>
          <div class="conteudo-fav">
            <div class="produto-exemplo">
              <img src="" alt="Produto">
              <div class="produto-info">
                <strong>Tênis Adidas</strong>
                <span>R$ 399,99</span>
              </div>
            </div>
          </div>
          <div class="botoes-sacola">
            <button class="btn-pagamento">PAGAMENTO</button>
            <button class="btn-acao" id="btn-voltar">CONTINUAR COMPRANDO</button>
          </div>
        </div>
      </div>

      <!-- 👤 LOGIN -->
      <div class="user-menu">
        <button class="icon-btn" id="user-icon">
          <img src="../src/assets/image/Login.svg" alt="Login">
        </button>
        <div class="dropdown-mini" id="user-dropdown">
          <button id="btn-entrar">Entrar</button>
          <button id="btn-criar">Criar Conta</button>
        </div>
      </div>
    </nav>
  </div>

  <!-- MENU PRINCIPAL -->
  <nav class="menu">
    <ul>
      <li><a href="#" data-cat="acessorios">Acessórios</a></li>
      <li><a href="#" data-cat="calcados">Calçados</a></li>
      <li><a href="#" data-cat="perfumes">Perfumes</a></li>
      <li><a href="#" data-cat="roupas">Roupas</a></li>
      <li><a href="#" data-cat="casual">Moda Casual</a></li>
      <li><a href="#" data-cat="intima">Moda Íntima</a></li>
      <li><a href="#" data-cat="ofertas">Ofertas</a></li>
    </ul>
  </nav>
</header>

<!-- ========== DROPDOWNS INDIVIDUAIS ========== -->

<!-- ACESSÓRIOS -->
<section class="categorias" id="cat-acessorios">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Colar</a>
    <a href="lista-produtos.php">Óculos</a>
    <a href="lista-produtos.php">Carteira</a>
    <a href="lista-produtos.php">Bag</a>
    <a href="lista-produtos.php">Corrente</a>
    <a href="lista-produtos.php">Boné</a>
    <a href="lista-produtos.php">Pulseira</a>
    <a href="lista-produtos.php">Relógio</a>
    <a href="lista-produtos.php">Cinto</a>
  </div>
</section>

<!-- CALÇADOS -->
<section class="categorias" id="cat-calcados">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Tênis</a>
    <a href="lista-produtos.php">Sapatênis</a>
    <a href="lista-produtos.php">Chinelo</a>
    <a href="lista-produtos.php">Bota</a>
    <a href="lista-produtos.php">Sandália</a>
  </div>
</section>

<!-- PERFUMES -->
<section class="categorias" id="cat-perfumes">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Importados</a>
    <a href="lista-produtos.php">Amadeirados</a>
    <a href="lista-produtos.php">Doces</a>
    <a href="lista-produtos.php">Frescos</a>
  </div>
</section>

<!-- ROUPAS -->
<section class="categorias" id="cat-roupas">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Camisetas</a>
    <a href="lista-produtos.php">Moletom</a>
    <a href="lista-produtos.php">Calças</a>
    <a href="lista-produtos.php">Shorts</a>
    <a href="lista-produtos.php">Conjuntos</a>
  </div>
</section>

<!-- CASUAL -->
<section class="categorias" id="cat-casual">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Camisas</a>
    <a href="lista-produtos.php">Polos</a>
    <a href="lista-produtos.php">Bermudas</a>
  </div>
</section>

<!-- ÍNTIMA -->
<section class="categorias" id="cat-intima">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Cuecas</a>
    <a href="lista-produtos.php">Meias</a>
    <a href="lista-produtos.php">Pijamas</a>
  </div>
</section>

<!-- OFERTAS -->
<section class="categorias" id="cat-ofertas">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Promoções</a>
    <a href="lista-produtos.php">Descontos</a>
    <a href="lista-produtos.php">Outlet</a>
  </div>
</section>

<!-- LOGIN POPUP -->
<section class="popup" id="popup-login">
  <div class="login">
    <h2>Login</h2>
    <label>CPF OU E-MAIL</label>
    <input type="text" placeholder="Digite seu CPF ou E-Mail">
    <label>SENHA</label>
    <input type="password" placeholder="Digite sua Senha">
    <button class="btn-entrar">ENTRAR</button>
    <div class="links">
      <a href="#" id="link-criar">CRIAR UMA CONTA?</a>
      <a href="#">ESQUECI MINHA SENHA</a>
    </div>
  </div>
</section>

<!-- CRIAR CONTA POPUP -->
<section class="popup" id="popup-criar">
  <div class="container-criar">
    <h2>CRIAR CONTA</h2>
    <form class="formulario">
      <div class="coluna">
        <label>Nome</label>
        <input type="text" placeholder="Nome*">
        <label>CPF</label>
        <input type="text" placeholder="CPF*">
        <label>E-mail</label>
        <input type="text" placeholder="E-mail*">
        <label>Data de Nascimento</label>
        <input type="text" placeholder="Data de Nascimento*">
      </div>
      <div class="coluna">
        <label>Sobrenome</label>
        <input type="text" placeholder="Sobrenome">
        <label>Celular</label>
        <input type="text" placeholder="Celular">
        <label>Senha</label>
        <input type="password" placeholder="Senha">
        <a href="#" id="link-login">JÁ POSSUI UMA CONTA?</a>
      </div>
    </form>
    <button class="botao">CRIAR CONTA</button>
  </div>
</section>

<!-- Faixa Promocional -->
<div class="promo-bar">
  <div class="promo-text">
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -  
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -  
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -
  </div>
</div>

<!-- BANNER PRINCIPAL -->
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
      <img src="" alt="Banner 3">
      <a href="lista-produtos.php" class="btn-acao banner-btn">Ver Produtos</a>
    </div>
  </div>
</section>

<!-- MARCAS -->
<section class="carousel marcas" id="marcasCarousel">
  <h2>Navegação por Marcas</h2>
  <div class="carousel-track">
    <nav>
      <a href="lista-produtos.php"><img src="../src/assets/image/nike.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/puma.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/adidas.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/LV.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/lacoste.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/gucci.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/New Balance.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/balenciaga.svg" alt=""></a>
      <a href="lista-produtos.php"><img src="../src/assets/image/EA7.svg" alt=""></a>
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
        <a href="pagina-produto.php" class="thumb">
          <img src="../src/assets/image/shorts-nike.jpg" alt="Shorts Nike">
        </a>
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


<!-- Banner Acessórios -->
<section class="acess-bloco">
  <img class="acess-img" src="../src/assets/image/banner-acessorio.svg" alt="Acessórios sobre fundo escuro">
  <div class="acess-txt">
    <h1 class="acess-titulo">
      O UNIVERSO<br>DOS<br>ACESSÓRIOS
    </h1>
    <p class="acess-sub">
      Peças atemporais e modernas que<br>
      definem a sua identidade.
    </p>
    <a href="lista-produtos.php" class="acess-btn">VER PRODUTOS</a>
  </div>
</section>

<!-- COMPLETE O SEU LOOK -->
<section class="carrossel-look">
  <h2>Complete o Seu Look</h2>

  <div class="carrossel-container1">
    <div class="carrossel-track1">
      <!-- ITEM 1 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/bag.svg" alt="Bolsa">
        </a>
      </div>

      <!-- ITEM 2 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/relogio.svg" alt="Relógio">
        </a>
      </div>

      <!-- ITEM 3 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/shorts (2).svg" alt="Shorts">
        </a>
      </div>

      <!-- ITEM 4 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/sueter.svg" alt="Moletom">
        </a>
      </div>

      <!-- ITEM 5 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/tennis_NIkE.svg" alt="Tênis">
        </a>
      </div>

      <!-- ITEM 6 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/camiseta_puma.svg" alt="Camiseta">
        </a>
      </div>

      <!-- ITEM 7 -->
      <div class="item">
        <a href="pagina-produto.php">
          <img src="../src/assets/image/conjunto (2).svg" alt="Conjunto">
        </a>
      </div>
    </div>
  </div>
</section>

<!-- banner final  -->
 <section class="essencia-bloco">
  <img class="essencia-img" src="../src/assets/image/banner3.svg" alt="essencia">
  
  <div class="essencia-texto">
    <h1 class="essencia-titulo">
      VISTA O <br>
      QUE <br> 
      COMBINA <br>
      COM A <br> 
      SUA <br>
      ESSÊNCIA.
    </h1>
    <a href="lista-produtos.php" class="acess-btn">VER PRODUTOS</a>
  </div>
</section>

<footer>
    <!-- Benefícios -->
<div class="beneficios-container">
<div class="beneficio">
<img src="../src/assets/image/"alt="Entrega">
<div class="texto">
<strong>Entrega expressa</strong>
<span>a partir de 1 dia útil</span>
</div>
</div>

<div class="beneficio">
<img src="../src/assets/image/"alt="Parcelamento">
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
</html