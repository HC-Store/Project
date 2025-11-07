<?php
include_once("conexao.php");

$id = $_GET['id'] ?? null;

if (!$id) {
  die("Produto não encontrado.");
}

// Consulta produto principal
$sql = "SELECT * FROM produtos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$produto = $result->fetch_assoc();

if (!$produto) {
  die("Produto não encontrado no banco de dados.");
}

// Consulta imagens adicionais (se houver tabela de imagens)
$imagens = [];
if ($conn->query("SHOW TABLES LIKE 'produtos_imagens'")->num_rows) {
  $sqlImg = "SELECT imagem_url FROM produtos_imagens WHERE produto_id = ?";
  $stmtImg = $conn->prepare($sqlImg);
  $stmtImg->bind_param("i", $id);
  $stmtImg->execute();
  $resultImg = $stmtImg->get_result();
  while ($row = $resultImg->fetch_assoc()) {
    $imagens[] = $row['imagem_url'];
  }
}

// Caso não tenha imagens no banco, usa as padrões
if (empty($imagens)) {
  $imagens = [
    "../src/assets/image/modelo.svg.svg",
    "../src/assets/image/frente.svg.svg",
    "../src/assets/image/lado.svg.svg",
    "../src/assets/image/costas.svg.svg"
  ];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($produto['nome']) ?></title>
  <link rel="stylesheet" href="../src/assets/css/pagina-produto.css">
  <script src="../src/assets/js/produto-galeria.js" defer></script>
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
            <p>Sua lista está vazia</p>
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
          <h3>MINHA SACOLA (0)</h3>
          <div class="conteudo-fav">
            <p>Sua sacola está vazia</p>
          </div>
          <div class="botoes-sacola">
            <button class="btn-pagamento" onclick="window.location.href='checkout.php'">PAGAMENTO</button>
            <button class="btn-acao">CONTINUAR COMPRANDO</button>
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
</header>

<section class="produto">
  <div class="produto-imagem">
    <img id="imagem-principal" src="<?= htmlspecialchars($produto['imagem_url'] ?? $imagens[0]) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>">
  </div>

  <div class="detalhes">
    <h2><?= htmlspecialchars($produto['nome']) ?></h2>
    <p class="preco"><strong>R$<?= number_format($produto['preco'], 2, ',', '.') ?></strong></p>

    <h3>COR</h3>
    <div class="color-dots">
      <span class="dot azul" title="Azul"></span>
      <span class="dot branco" title="Branco"></span>
    </div>

    <h3>TAMANHO</h3>
    <?php foreach (["P","M","G","GG","XL"] as $t): ?>
      <label><input type="radio" name="tamanho" value="<?= $t ?>"> <?= $t ?></label>
    <?php endforeach; ?>

    <div class="acoes">
      <button class="btn-carrinho">Adicionar ao Carrinho</button>
      <button class="btn-favorito"><img src="../src/assets/image/Coração.svg" width="18"></button>
    </div>

    <button class="btn-comprar" onclick="window.location.href='checkout.php'">Comprar</button>

    <h3>Sobre Produto:</h3>
    <div class="descricao">
      <p><?= htmlspecialchars($produto['descricao']) ?></p>
    </div>
  </div>
</section>

<section class="galeria">
  <div class="miniaturas">
    <?php foreach ($imagens as $img): ?>
      <article><img src="<?= htmlspecialchars($img) ?>" alt="miniatura"></article>
    <?php endforeach; ?>
  </div>
</section>

<section class="relacionados">
  <h3>Você também pode gostar</h3>
  <div class="lista-relacionados">
    <?php
    $rel = $conn->query("SELECT id, nome, preco, imagem_url FROM produtos ORDER BY RAND() LIMIT 5");
    while ($r = $rel->fetch_assoc()):
    ?>
      <article class="card-produto">
        <img src="<?= htmlspecialchars($r['imagem_url']) ?>" alt="">
        <h4><?= htmlspecialchars($r['nome']) ?></h4>
        <p>R$<?= number_format($r['preco'], 2, ',', '.') ?></p>
        <button onclick="window.location.href='pagina-produto.php?id=<?= $r['id'] ?>'">Ver Mais</button>
      </article>
    <?php endwhile; ?>
  </div>
</section>

<!-- Banner -->
<div class="banner">
  <img src="../src/assets/image/frete-gratis.svg" alt="Banner de Frete Grátis">
</div>

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
<img src="../src/assets/image/parcelas.svg"alt="Parcelamento">
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
<a class="link" href="#">Cancelamentos</a>
</nav>

<nav>
<h2 class="text">Institucional</h2>
<a class="link" href="#">Sobre a Hc Store</a>
<a class="link" href="#">Nossa Loja</a>
<a class="link" href="#">Termos de Uso</a>
<a class="link" href="#">Privacidade</a>
</nav>

<nav>
<h2 class="text">Políticas</h2>
<a class="link" href="#">Regulamentos</a>
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

