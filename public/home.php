

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
<?php
require_once "../conexao.php";

$produtos = $pdo->query("
    SELECT p.id, p.nome, p.preco_venda,
    (SELECT caminho FROM produto_imagens 
     WHERE produto_id = p.id ORDER BY ordenacao ASC LIMIT 1) AS imagem
    FROM produtos p
    ORDER BY p.id DESC
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);
?>


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
<?php foreach ($produtos as $p): 
    // caminho da imagem (fallback se nulo)
    $img = $p['imagem'] ? trim($p['imagem']) : 'src/assets/image/default-product.jpg';

    // se a imagem salva for relativa sem ../, ajuste conforme sua estrutura
    // aqui assumimos que a home está em /admin/ ou similar e usamos ../ para subir uma pasta
    $imgPath = file_exists(__DIR__ . '/../' . $img) ? '../' . $img : $img;
?>
    <li class="product-card" data-id="<?= (int)$p['id'] ?>">
        <button class="fav" aria-label="Favoritar">♥</button>

        <a href="pagina-produto.php?id=<?= (int)$p['id'] ?>" class="thumb">
            <img 
                src="<?= htmlspecialchars($imgPath, ENT_QUOTES) ?>" 
                alt="<?= htmlspecialchars($p['nome'], ENT_QUOTES) ?>" 
                loading="lazy"
                onerror="this.src='../src/assets/image/default-product.jpg'">
        </a>

        <h3 class="title"><?= htmlspecialchars($p['nome']) ?></h3>

        <strong class="price">
            R$ <?= number_format((float)$p['preco_venda'], 2, ',', '.') ?>
        </strong>

        <button class="btn add-cart" data-id="<?= $p['id'] ?>">Adicionar ao Carrinho</button>

    </li>
<?php endforeach; ?>
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
<script>
document.querySelectorAll('.add-cart').forEach(btn => {
    btn.addEventListener('click', async () => {

        let id = btn.getAttribute('data-id');

        const res = await fetch("cart_action.php", {
            method: "POST",
            body: new URLSearchParams({
                action: "add",
                id: id
            })
        });

        const json = await res.json();

        if (json.success) {
            alert("Produto adicionado na sacola!");
        } else {
            alert("Erro: " + json.message);
        }
    });
});
</script>


</body>
</html>