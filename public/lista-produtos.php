<?php

include '../conexao.php';


/* ==================== FILTROS ==================== */
$category = $_GET['category'] ?? '';
$size     = $_GET['size']     ?? '';
$color    = $_GET['color']    ?? '';
$priceMax = $_GET['price']    ?? '';
$page     = max(1, intval($_GET['page'] ?? 1));

$perPage = 12;
$offset  = ($page - 1) * $perPage;

function keep(array $extra = []) {
  $params = array_merge($_GET, $extra);
  return http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));
}

/* ==================== SQL DINÂMICO ==================== */
$where = [];
$params = [];

if ($category !== '') {
  $where[] = "p.categoria = ?";
  $params[] = $category;
}

if ($priceMax !== '') {
  $where[] = "p.preco_venda <= ?";
  $params[] = $priceMax;
}

if ($size !== '') {
  $where[] = "v.tamanho = ?";
  $params[] = $size;
}

if ($color !== '') {
  $where[] = "v.cor = ?";
  $params[] = $color;
}

$whereSql = $where ? "WHERE " . implode(" AND ", $where) : "";

/* ==================== TOTAL ==================== */
$sqlTotal = "
    SELECT COUNT(DISTINCT p.id)
    FROM produtos p
    LEFT JOIN variacoes v ON v.produto_id = p.id
    $whereSql
";

$stmt = $pdo->prepare($sqlTotal);
$stmt->execute($params);
$totalItems = (int)$stmt->fetchColumn();
$totalPages = max(1, (int)ceil($totalItems / $perPage));

/* ==================== PRODUTOS ==================== */
$sql = "
    SELECT 
        p.id,
        p.nome,
        p.preco_venda,
        p.categoria,
        (
            SELECT caminho 
            FROM produto_imagens 
            WHERE produto_id = p.id 
            ORDER BY ordenacao ASC 
            LIMIT 1
        ) AS imagem
    FROM produtos p
    LEFT JOIN variacoes v ON v.produto_id = p.id
    $whereSql
    GROUP BY p.id
    ORDER BY p.criado_em DESC
    LIMIT $offset, $perPage
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Produtos</title>

    <link rel="stylesheet" href="../src/assets/css/header-public.css">
    <link rel="stylesheet" href="../src/assets/css/lista-produtos.css">

    <script src="../src/assets/js/header-public.js" defer></script>
    <script src="../src/assets/js/lista-produtos.js" defer></script>
</head>
<body>

<?php 
$mostrarMenu = true;
include_once("../src/includes/header-public.php");
?>

<!-- Faixa Promocional -->
<div class="promo-bar">
  <div class="promo-text">
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -
    15% OFF - CUPOM: PRIMEIRA15 - 15% OFF - CUPOM: PRIMEIRA15 -
  </div>
</div>

<!-- Banner -->
<div class="banner">
  <img src="../src/assets/image/banner.svg" alt="Banner">
</div>


<!-- ================= CONTEÚDO ================= -->
<div class="page-content">

  <!-- FILTROS -->
  <aside class="menuLateral">
    <form action="" method="GET">
      <input type="hidden" name="category" value="<?= htmlspecialchars($category) ?>">

      <h2>Filtro</h2>

      <!-- TAMANHO -->
      <h3>Tamanhos</h3>
      <?php foreach (["P","M","G","GG","XL","2XL"] as $t): ?>
        <label>
          <input type="radio" name="size" value="<?= $t ?>" <?= $size==$t?'checked':'' ?>>
          <?= $t ?>
        </label>
      <?php endforeach; ?>

      <!-- COR -->
      <h3>Cor</h3>
      <?php
        $cores = [
          'Preto'=>'#212121',
          'Branco'=>'#ffffff',
          'Cinza'=>'#9e9e9e',
          'Azul'=>'#3d5afe',
          'Vermelho'=>'#ff2b2b',
          'Laranja'=>'#ff9800',
          'Verde'=>'#4caf50'
        ];
        foreach ($cores as $nome=>$hex):
      ?>
        <label class="radio-color">
          <input type="radio" name="color" value="<?= $nome ?>" <?= $color==$nome?'checked':'' ?>>
          <span class="swatch" style="--c: <?= $hex ?>"></span> <?= $nome ?>
        </label>
      <?php endforeach; ?>

      <!-- PREÇO -->
      <h3>Preço Máximo</h3>
      <input type="range" min="0" max="2000" step="50" name="price" value="<?= $priceMax ?: 2000 ?>">
      <span class="preco-label">Até R$ <?= $priceMax ?: "2000,00" ?></span>

      <button class="btn-filtrar" type="submit">FILTRAR</button>
    </form>
  </aside>


  <!-- PRODUTOS -->
  <main>
    <h1><?= $category ? ucfirst($category) : "Produtos" ?></h1>
    <p><?= $totalItems ?> itens encontrados</p>

    <section class="Produtos">

      <?php if ($products): ?>
        <?php foreach ($products as $p): ?>
          <article class="product-card">

            <button class="fav" aria-label="Favoritar">♥</button>

            <a class="link-produto" href="pagina-produto.php?id=<?= urlencode($p['id']) ?>">
              <img src="<?= htmlspecialchars($p['imagem'] ?: '../src/assets/image/sem-foto.svg') ?>" 
                   alt="<?= htmlspecialchars($p['nome']) ?>">

              <h3 class="title"><?= htmlspecialchars($p['nome']) ?></h3>

              <p class="price">
                R$ <?= number_format($p['preco_venda'], 2, ',', '.') ?>
              </p>
            </a>

            <form action="checkout.php" method="GET">
              <input type="hidden" name="produto" value="<?= htmlspecialchars($p['id']) ?>">
              <button class="btn" type="submit">COMPRAR</button>
            </form>

          </article>
        <?php endforeach; ?>

      <?php else: ?>
        <p>Nenhum produto encontrado com os filtros informados.</p>
      <?php endif; ?>

    </section>

    <!-- PAGINAÇÃO -->
    <div class="MudarPagina">
      <?php if ($page > 1): ?>
        <a href="?<?= keep(['page'=>$page-1]) ?>">Anterior</a>
      <?php endif; ?>

      <?php for ($i=1; $i <= $totalPages; $i++): ?>
        <a class="<?= $i==$page?'active':'' ?>" href="?<?= keep(['page'=>$i]) ?>">
          <?= $i ?>
        </a>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <a href="?<?= keep(['page'=>$page+1]) ?>">Próximo</a>
      <?php endif; ?>
    </div>

  </main>
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
