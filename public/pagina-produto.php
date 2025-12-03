<?php 
/* =========================
   CONEXÃO (PDO)
========================= */
include '../conexao.php';

/* =========================
   BUSCA DO PRODUTO
========================= */
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) die("Produto não encontrado.");

/*  
   NOVA QUERY USANDO A TABELA DO BANCO NOVO:
   produtos + variacoes (tamanho, cor, estoque)
*/
$stmt = $pdo->prepare("
  SELECT 
    p.id,
    p.nome,
    p.descricao,
    p.categoria,
    p.preco_venda,
    v.tamanho,
    v.cor,
    v.estoque
  FROM produtos p
  LEFT JOIN variacoes v ON v.produto_id = p.id
  WHERE p.id = ?
");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) die("Produto não encontrado no banco.");

/* =========================
   IMAGEM PRINCIPAL (via produto_imagens)
========================= */
$imagemPrincipal = "../src/assets/image/sem-foto.svg";

$stImg = $pdo->prepare("
  SELECT caminho 
  FROM produto_imagens
  WHERE produto_id = ?
  ORDER BY ordenacao ASC, id ASC
  LIMIT 1
");
$stImg->execute([$id]);
$img = $stImg->fetchColumn();

if (!empty($img)) {
  // garante que a imagem sempre suba uma pasta corretamente
  $imagemPrincipal = "../" . ltrim($img, "/");
}


/* =========================
   GALERIA COMPLETA
========================= */
$imagens = [];

$stGal = $pdo->prepare("
  SELECT caminho 
  FROM produto_imagens
  WHERE produto_id = ?
  ORDER BY ordenacao ASC, id ASC
");
$stGal->execute([$id]);
$lista = $stGal->fetchAll(PDO::FETCH_COLUMN);

if ($lista) {
  $imagens = array_map(function($img){
    return "../" . ltrim($img, "/");
  }, $lista);
} else {
  // fallback para não quebrar layout
  $imagens = [
    $imagemPrincipal,
    "../src/assets/image/sem-foto.svg",
    "../src/assets/image/sem-foto.svg",
    "../src/assets/image/sem-foto.svg"
  ];
}

/* =========================
   LISTA DE TAMANHOS DISPONÍVEIS
========================= */
$stSizes = $pdo->prepare("
  SELECT DISTINCT tamanho 
  FROM variacoes
  WHERE produto_id = ?
  AND tamanho IS NOT NULL AND tamanho <> ''
");
$stSizes->execute([$id]);
$tamanhos = $stSizes->fetchAll(PDO::FETCH_COLUMN);

if (!$tamanhos) {
  // fallback para não quebrar o layout
  $tamanhos = ["P","M","G","GG","XL"];
}

/* =========================
   COR DO PRODUTO
========================= */
$cor = !empty($produto['cor']) ? $produto['cor'] : "Única";

/* =========================
   RELACIONADOS
========================= */
$relacionados = [];

if (!empty($produto['categoria'])) {
  $stRel = $pdo->prepare("
    SELECT 
      id,
      nome,
      preco_venda,
      (SELECT caminho FROM produto_imagens WHERE produto_id = produtos.id ORDER BY ordenacao ASC, id ASC LIMIT 1)
        AS imagem
    FROM produtos
    WHERE categoria = ? AND id <> ?
    ORDER BY criado_em DESC
    LIMIT 8
  ");
  $stRel->execute([$produto['categoria'], $produto['id']]);
  $relacionados = $stRel->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($produto['nome']) ?> | HC Store</title>

  <link rel="stylesheet" href="../src/assets/css/header-public.css">
  <!-- CSS da página -->
  <link rel="stylesheet" href="../src/assets/css/pagina-produto.css"/>
  <script src="../src/assets/js/header-public.js" defer></script>
  <!-- JS da página -->
 <script defer src="../src/assets/js/pagina-produto.js"></script>

</head>
<body>

<?php 
$mostrarMenu = false;
include_once("../src/includes/header-public.php"); 
?>

<main class="produto-container">
<!-- ================= IMAGEM + DETALHES ================= -->
    <section class="produto">

        <!-- COLUNA ESQUERDA – IMAGEM PRINCIPAL -->
        <div class="produto-imagem">
            <img id="imagem-principal"
                 src="<?= htmlspecialchars($imagemPrincipal) ?>"
                 alt="Imagem do Produto">
        </div>

        <!-- COLUNA DIREITA – DETALHES -->
        <div class="detalhes">
            <h1 class="titulo-prod"><?= htmlspecialchars($produto['nome']) ?></h1>

            <p class="preco">
                <strong>R$ <?= number_format($produto['preco_venda'], 2, ',', '.') ?></strong>
            </p>

            <!-- COR -->
            <?php if (!empty($cor)): ?>
                <h3>Cor</h3>
                <div class="color-dots">
                    <span class="dot"
                          title="<?= htmlspecialchars($cor) ?>"
                          style="background:#ddd;"></span>
                </div>
            <?php endif; ?>

            <!-- TAMANHOS -->
            <h3>Tamanho</h3>
            <div class="grade-tamanho">
                <?php foreach ($tamanhos as $t): ?>
                    <label>
                        <input type="radio" name="tamanho" value="<?= htmlspecialchars($t) ?>">
                        <?= htmlspecialchars($t) ?>
                    </label>
                <?php endforeach; ?>
            </div>

            <!-- AÇÕES -->
            <div class="acoes">
       <div class="acoes">
  <button class="btn-carrinho" id="btn-add-carrinho" data-id="<?= $produto['id'] ?>">
    Adicionar à Sacola
  </button>

               <button class="btn-favorito" id="btn-add-favorito">♥</button>
</div>
            </div>

        <form action="checkout.php" method="POST">
  <input type="hidden" name="comprar_agora" value="<?= (int)$produto['id'] ?>">
 <button class="btn-comprar" id="btn-comprar">
  COMPRAR
</button>
</form>


            <!-- DESCRIÇÃO -->
            <h3>Sobre o produto</h3>
            <div class="descricao">
                <p><?= nl2br(htmlspecialchars($produto['descricao'])) ?></p>
            </div>
        </div>

    </section>

    <!-- ================= MINIATURAS ================= -->
    <section class="galeria">
        <div class="miniaturas">
            <?php foreach ($imagens as $img): ?>
                <img class="mini"
                     src="<?= htmlspecialchars($img) ?>"
                     alt="Miniatura">
            <?php endforeach; ?>
        </div>
    </section>

    <!-- ================= RELACIONADOS ================= -->
    <?php if (!empty($relacionados)): ?>
        <section class="relacionados">
            <h3>Você também pode gostar</h3>

            <div class="lista-relacionados">
                <?php foreach ($relacionados as $r): ?>
                    <article class="card-produto">
                        <a href="pagina-produto.php?id=<?= (int)$r['id'] ?>" class="link-produto">
                            <img src="<?= htmlspecialchars($r['imagem'] ? '../'.ltrim($r['imagem'],'/') : '../src/assets/image/sem-foto.svg') ?>">
                                 

                            <h4><?= htmlspecialchars($r['nome']) ?></h4>
                            <p><strong>R$ <?= number_format($r['preco_venda'], 2, ',', '.') ?></strong></p>

                            <button type="button">Ver mais</button>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- BANNER INFERIOR -->
    <div class="banner">
      <img src="../src/assets/image/frete-gratis.svg" alt="Frete grátis">
    </div>

</main>
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
document.getElementById("btn-add-carrinho").addEventListener("click", function () {

  const produtoId = this.dataset.id;

  fetch("cart_action.php", {
    method: "POST",
    body: new URLSearchParams({
      produto_id: produtoId
    })
  })
  .then(r => r.json())
  .then(json => {
    if (json.success) {
      alert("Produto adicionado à sacola!");
      location.reload();
    } else {
      alert(json.message);
    }
  })
  .catch(() => alert("Erro ao adicionar produto."));
});
</script>


 



</body>
</html>



