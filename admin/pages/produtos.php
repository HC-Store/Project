<?php 
require_once __DIR__ . '/../../conexao.php';

// PUXA TODOS OS PRODUTOS
$sql = $pdo->query("
    SELECT 
        p.id,
        p.nome,
        p.descricao,
        p.quantidade AS estoque,
        p.categoria,
        p.marca,
        p.preco_venda AS preco,
        (
            SELECT caminho 
            FROM produto_imagens 
            WHERE produto_id = p.id 
            ORDER BY ordenacao ASC 
            LIMIT 1
        ) AS imagem,
        (
            SELECT SUM(quantidade) 
            FROM pedido_itens 
            WHERE produto_id = p.id
        ) AS vendas
    FROM produtos p
    ORDER BY p.id DESC
");

$produtos = $sql->fetchAll();
?>

<link rel="stylesheet" href="pages/produtos.css">

<div class="produtos-header">
  <div>
    <h1>Todos os Produtos</h1>
    <p class="breadcrumb">Home > Todos os Produtos</p>
  </div>

  <button class="add-produto" onclick="apagarSelecionados()">
    APAGAR PRODUTOS
  </button>
</div>

<section class="produtos-grid">

<?php foreach($produtos as $p): ?>
  <article class="produto-card">

    <img src="<?= $p['imagem'] ? '../../uploads/'.$p['imagem'] : '../src/assets/image/adidastenis.svg' ?>" alt=""> 

    <h2><?= htmlspecialchars($p['nome']) ?></h2>

    <p class="tipo"><?= htmlspecialchars($p['categoria'] ?? "Sem categoria") ?></p>

    <p class="preco">R$<?= number_format($p['preco'], 2, ',', '.') ?></p>

    <p class="descricao"><?= htmlspecialchars($p['descricao']) ?></p>

    <div class="info">
      <span>Vendas</span>  
      <strong><?= $p['vendas'] ?? 0 ?></strong>

      <span>Produtos restantes</span> 
      <strong><?= $p['estoque'] ?></strong>
    </div>

    <label class="checkbox-area">
        <input type="checkbox" class="produto-check" value="<?= $p['id'] ?>">
        Selecionar
    </label>

  </article>
<?php endforeach; ?>
</section>

<script src="pages/produtos.js"></script>
