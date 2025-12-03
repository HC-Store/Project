<?php
session_start();

include '../conexao.php';

/* ================================
   IDENTIFICA USUÁRIO
================================ */
if (!isset($_SESSION['user_id'])) {
    die("ERRO: usuário não está logado.");
}

$userId = $_SESSION['user_id'];

/* ================================
   CARREGA ITENS DO CARRINHO
   (mesma lógica que já funciona)
================================ */
$stmt = $pdo->prepare("
  SELECT 
    ci.id, 
    ci.quantity, 
    p.id AS product_id, 
    p.nome AS name, 
    p.preco_venda AS sale_price, 
    (
      SELECT caminho 
      FROM produto_imagens pi 
      WHERE pi.produto_id = p.id 
      ORDER BY ordenacao ASC LIMIT 1
    ) AS image_url
  FROM cart_items ci
  JOIN produtos p ON p.id = ci.product_id
  WHERE ci.user_id = ?
");
$stmt->execute([$userId]);
$cart = $stmt->fetchAll();

/* ================================
   CÁLCULO DO SUBTOTAL
================================ */
$subtotal = 0;
foreach ($cart as $c) {
    $subtotal += $c['sale_price'] * $c['quantity'];
}

/* FRETE */
$frete = 20.00;

/* CUPOM (não aplicado aqui) */
$discount = 0;

/* TOTAL */
$total = $subtotal + $frete;

/* FORMULÁRIO */
$cep         = $_POST['cep'] ?? '';
$estado      = $_POST['estado'] ?? '';
$cidade      = $_POST['cidade'] ?? '';
$endereco    = $_POST['endereco'] ?? '';
$bairro      = $_POST['bairro'] ?? '';
$numero      = $_POST['numero'] ?? '';
$complemento = $_POST['complemento'] ?? '';

/* ================================
   PROCESSAR PAGAMENTO
================================ */
$sucesso = false;
$paymentPayload = null;
$paymentMethod  = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar_pagamento'])) {

    $paymentMethod = $_POST['pagamento'];

    $pdo->beginTransaction();

    try {

        /* ================================
           1. CRIA PEDIDO EM "pedidos"
        ================================= */
        $stmtPedido = $pdo->prepare("
          INSERT INTO pedidos (usuario_id, valor_total, status)
          VALUES (?, ?, 'pendente')
        ");
        $stmtPedido->execute([$userId, $total]);

        $pedidoId = $pdo->lastInsertId();

        /* ================================
           2. INSERE ITENS DO PEDIDO
        ================================= */
        $stmtItens = $pdo->prepare("
          INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario)
          VALUES (?, ?, ?, ?)
        ");

        foreach ($cart as $item) {
            $stmtItens->execute([
                $pedidoId,
                $item['product_id'],
                $item['quantity'],
                $item['sale_price']
            ]);
        }

        /* ================================
           3. SALVAR PAGAMENTO EM "pagamentos"
        ================================= */
        if ($paymentMethod === 'pix') {
    $paymentPayload = "000201PIX_FAKE_" . rand(10000, 99999);
} elseif ($paymentMethod === 'boleto') {
    $paymentPayload = "34191.79001.01043.510047.91020.150008.1.00000000000000";
} else {
    $paymentPayload = "TX-" . strtoupper(bin2hex(random_bytes(5)));
}

$stmtPagamento = $pdo->prepare("
    INSERT INTO pagamentos (pedido_id, usuario_id, valor, metodo_pagamento, status_pagamento)
    VALUES (?, ?, ?, ?, ?)
");
$stmtPagamento->execute([
    $pedidoId,
    $userId,
    $total,
    $paymentMethod,
    'pendente'
]);

        /* ================================
           4. LIMPA CARRINHO DO USUÁRIO
        ================================= */
        $stmtClear = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmtClear->execute([$userId]);

        $pdo->commit();
        $sucesso = true;

    } catch (Exception $e) {
        $pdo->rollBack();
        $erro = "Erro ao processar pagamento: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Pagamento</title>

<link rel="stylesheet" href="../src/assets/css/pagamento.css">
<script defer src="../src/assets/js/pagamento.js"></script>
</head>

<body>

<header>
  <div class="container">
    <input type="text" placeholder="O que você deseja ?">
    <a href="home.php">
      <img class="logo" src="../src/assets/image/logo.svg" alt="logo loja">
    </a>
  </div>
</header>

<section class="pagamento">

  <div class="pagamento-info">

    <h1>PAGAMENTO</h1>

    <?php if (!empty($sucesso)): ?>
      <div class="alert success">Pagamento iniciado com sucesso!</div>
    <?php endif; ?>

    <form method="POST" class="form-pagamento">

      <button type="button" id="btn-selecionar" class="form-pag">
        SELECIONAR FORMA DE PAGAMENTO
      </button>

      <div class="metodos" id="metodos" style="display:none;">
        <label><input type="radio" name="pagamento" value="cartao" checked> Cartão</label>
        <label><input type="radio" name="pagamento" value="boleto"> Boleto</label>
        <label><input type="radio" name="pagamento" value="pix"> Pix</label>
      </div>

      <!-- Cartão -->
      <div class="painel" id="painel-cartao" style="display:block;">
        <h3>CARTÃO DE CRÉDITO</h3>

        <label>Número</label>
        <input type="text">

        <label>Nome</label>
        <input type="text">

        <label>Validade</label>
        <input type="text">

        <label>CVV</label>
        <input type="text">

        <label>Parcelas</label>
        <select name="parcelas">
          <option>1x Sem juros</option>
          <option>2x Sem juros</option>
          <option>3x Sem juros</option>
        </select>
      </div>

      <!-- Boleto -->
      <div class="painel" id="painel-boleto" style="display:none;">
        <h3>BOLETO</h3>
        <p>O boleto será gerado após a confirmação.</p>
      </div>

      <!-- Pix -->
      <div class="painel" id="painel-pix" style="display:none;">
        <h3>PIX</h3>
        <p>Copie e Cole ou Escaneie o QR CODE.</p>
      </div>

      <button type="submit" name="confirmar_pagamento" class="btn-confirmar">
        FINALIZAR PAGAMENTO
      </button>
    </form>

    <?php if ($sucesso): ?>
      <div class="pos-pagamento">

        <?php if ($paymentMethod === 'pix'): ?>
          <textarea class="codebox"><?= $paymentPayload ?></textarea>

        <?php elseif ($paymentMethod === 'boleto'): ?>
          <div class="boleto-line"><?= $paymentPayload ?></div>

        <?php else: ?>
          <p>Pagamento com cartão em análise.</p>
          <p>ID transação: <b><?= $paymentPayload ?></b></p>
        <?php endif; ?>

      </div>
    <?php endif; ?>

  </div>

  <aside class="resumo">
    <h2>Resumo do Pedido</h2>

    <p>Subtotal: R$ <?= number_format($subtotal,2,',','.') ?></p>
    <p>Frete: R$ <?= number_format($frete,2,',','.') ?></p>
    <p><b>Total: R$ <?= number_format($total,2,',','.') ?></b></p>
  </aside>

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