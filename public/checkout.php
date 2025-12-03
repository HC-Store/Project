<?php
session_start();

/* =========================
   CONEXÃO COM O BANCO
========================= */
include '../conexao.php';

/* =========================
   USUÁRIO LOGADO (usuarios)
========================= */
$userId = $_SESSION['user_id'] ?? $_SESSION['id'] ?? null;

$usuario = null;
if ($userId) {
  // usuarios: id, nome, email, senha, tipo, criado_em
  $stmtUser = $pdo->prepare("
    SELECT id, nome AS name, email, NULL AS phone
    FROM usuarios
    WHERE id = ?
  ");
  $stmtUser->execute([$userId]);
  $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC) ?: null;
}

/* =========================
   ITENS DO CARRINHO
   cart_items + produtos + produto_imagens
========================= */
$itensCarrinho = [];

if ($userId) {
  $stmtCart = $pdo->prepare("
    SELECT 
      c.id         AS cart_id,
      c.quantity   AS quantity,
      p.id         AS product_id,
      p.nome       AS name,
      COALESCE(img.caminho, '../src/assets/image/sem-foto.svg') AS image_url,
      p.preco_venda AS sale_price
    FROM cart_items c
    JOIN produtos p ON p.id = c.product_id
    LEFT JOIN (
      SELECT produto_id, MIN(caminho) AS caminho
      FROM produto_imagens
      GROUP BY produto_id
    ) img ON img.produto_id = p.id
    WHERE c.user_id = ?
  ");
  $stmtCart->execute([$userId]);
  $itensCarrinho = $stmtCart->fetchAll(PDO::FETCH_ASSOC);
}

/* =========================
   CÁLCULOS INICIAIS
========================= */
$subtotal = 0;
foreach ($itensCarrinho as $item) {
  $subtotal += (float)$item['sale_price'] * (int)$item['quantity'];
}

$frete         = 20.00;   // frete padrão
$discount      = 0.00;    // desconto inicial
$totalFinal    = $subtotal + $frete;
$erroCheckout  = '';
$cupomAplicado = '';

/* =========================
   TRATAMENTO DO POST
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Campos do formulário
  $email       = trim($_POST['email']      ?? '');
  $telefone    = trim($_POST['telefone']   ?? '');
  $nome        = trim($_POST['nome']       ?? '');
  $sobrenome   = trim($_POST['sobrenome']  ?? '');
  $cep         = trim($_POST['cep']        ?? '');
  $endereco    = trim($_POST['endereco']   ?? '');
  $bairro      = trim($_POST['bairro']     ?? '');
  $cidade      = trim($_POST['cidade']     ?? '');
  $estado      = trim($_POST['estado']     ?? '');
  $numero      = trim($_POST['numero']     ?? '');
  $complemento = trim($_POST['complemento']?? '');
  $cupom       = strtoupper(trim($_POST['cupom'] ?? ''));

  // Validações simples
  if (
    empty($email) || empty($nome) || empty($sobrenome) ||
    empty($cep) || empty($endereco) || empty($bairro) ||
    empty($cidade) || empty($estado)
  ) {
    $erroCheckout = "Preencha todos os campos obrigatórios.";
  } elseif (empty($itensCarrinho)) {
    $erroCheckout = "Seu carrinho está vazio.";
  } else {

    // Recalcula subtotal com base no banco
    $subtotal = 0;
    foreach ($itensCarrinho as $item) {
      $subtotal += (float)$item['sale_price'] * (int)$item['quantity'];
    }

    // CUPOM (tabela cupons)
    if ($cupom !== '') {
      $stmtCupom = $pdo->prepare("
        SELECT * 
        FROM cupons 
        WHERE code = ? 
          AND is_active = 1
          AND (expires_at IS NULL OR expires_at >= NOW())
        LIMIT 1
      ");
      $stmtCupom->execute([$cupom]);
      $cupomRow = $stmtCupom->fetch(PDO::FETCH_ASSOC);

      if ($cupomRow) {
        if ($cupomRow['type'] === 'percent') {
          $discount = round($subtotal * ((float)$cupomRow['amount'] / 100), 2);
        } else {
          $discount = min($subtotal, (float)$cupomRow['amount']);
        }
        $cupomAplicado = $cupomRow['code'];
      } else {
        $discount = 0;
        $erroCheckout = "Cupom inválido ou expirado.";
      }
    }

    // Total final (servidor manda)
    $totalFinal = max(0, $subtotal - $discount + $frete);

    if ($erroCheckout === '') {
      try {
        $pdo->beginTransaction();

        /* =========================
           PEDIDO (tabela pedidos)
           pedidos: id, usuario_id, valor_total, status, criado_em
        ========================= */
        $stmtOrder = $pdo->prepare("
          INSERT INTO pedidos (usuario_id, valor_total, status)
          VALUES (?, ?, 'pendente')
        ");
        $stmtOrder->execute([
          $userId,
          $totalFinal
        ]);

        $pedidoId = $pdo->lastInsertId();

        /* =========================
           ENDEREÇO (tabela enderecos)
           enderecos: id, usuario_id, rua, numero, bairro, cidade, estado, cep
           (aqui eu salvo o endereço usado no pedido)
        ========================= */
        $stmtEnd = $pdo->prepare("
          INSERT INTO enderecos (usuario_id, rua, numero, bairro, cidade, estado, cep)
          VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $ruaComComplemento = $complemento
          ? $endereco . ' - ' . $complemento
          : $endereco;

        $stmtEnd->execute([
          $userId,
          $ruaComComplemento,
          $numero,
          $bairro,
          $cidade,
          $estado,
          $cep
        ]);

        /* =========================
           ITENS DO PEDIDO (pedido_itens)
           pedido_itens: id, pedido_id, produto_id, variacao_id, quantidade, preco_unitario
        ========================= */
        $stmtItem = $pdo->prepare("
          INSERT INTO pedido_itens (pedido_id, produto_id, variacao_id, quantidade, preco_unitario)
          VALUES (?, ?, NULL, ?, ?)
        ");

        foreach ($itensCarrinho as $item) {
          $stmtItem->execute([
            $pedidoId,
            $item['product_id'],
            (int)$item['quantity'],
            (float)$item['sale_price']
          ]);
        }

        /* =========================
           LIMPA CARRINHO
        ========================= */
        $stmtClear = $pdo->prepare("DELETE FROM cart_items WHERE user_id = ?");
        $stmtClear->execute([$userId]);

        $pdo->commit();

        // Redireciona para pagamento (ajustado para pedido_id)
        header("Location: pagamento.php?pedido_id=" . $pedidoId);
        exit;

      } catch (Exception $e) {
        $pdo->rollBack();
        $erroCheckout = "Erro ao finalizar pedido. Tente novamente.";
      }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>

  <link rel="stylesheet" href="../src/assets/css/header-public.css">
  <link rel="stylesheet" href="../src/assets/css/checkout.css">
  <script src="../src/assets/js/header-public.js" defer></script>
  <script src="../src/assets/js/checkout.js" defer></script>
</head>

<body data-user="<?= $userId ? '1' : '0' ?>">

<?php 
  $mostrarMenu = false; 
  include_once("../src/includes/header-public.php"); 
?>

<main class="checkout">
  <!-- COLUNA ESQUERDA -->
  <section class="checkout-esquerda">
    <form method="post" class="form checkout-left">
      <h1 class="checkout-titulo">Contato</h1>
      <p class="section-subtitle">
        Usaremos essa forma de contato para manter você informado sobre o pedido
      </p>

      <label for="email">Digite seu Email*</label>
      <input 
        type="email" 
        id="email" 
        name="email" 
        value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES) ?>" 
        required
      >

      <label for="telefone">Número de Telefone</label>
      <input 
        type="tel" 
        id="telefone" 
        name="telefone" 
        value="<?= htmlspecialchars($usuario['phone'] ?? '', ENT_QUOTES) ?>"
        required
      >

      <h1 class="checkout-titulo">Endereço de Envio</h1>

      <div class="form-linha">
        <div>
          <label for="nome">Nome</label>
          <input 
            type="text" 
            id="nome" 
            name="nome" 
            value="<?= htmlspecialchars($usuario['name'] ?? '', ENT_QUOTES) ?>" 
            required
          >
        </div>
        <div>
          <label for="sobrenome">Sobrenome</label>
          <input 
            type="text" 
            id="sobrenome" 
            name="sobrenome" 
            required
          >
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
      <input type="text" id="endereco" name="endereco" readonly required>

      <label for="bairro">Bairro</label>
      <input type="text" id="bairro" name="bairro" readonly required>

      <label for="cidade">Cidade</label>
      <input type="text" id="cidade" name="cidade" readonly required>

      <label for="estado">Estado</label>
      <input type="text" id="estado" name="estado" readonly required>

      <div class="form-linha">
        <div>
          <label for="complemento">Casa ou Apart</label>
          <input type="text" id="complemento" name="complemento">
        </div>
        <div>
          <label for="numero">Número ou Bloco</label>
          <input type="number" id="numero" name="numero">
        </div>
      </div>

      <?php if (!empty($erroCheckout)): ?>
        <p class="checkout-erro"><?= htmlspecialchars($erroCheckout, ENT_QUOTES) ?></p>
      <?php endif; ?>

      <button type="submit" class="btn-finalizar">Finalizar Pedido</button>
    </form>
  </section>

  <!-- COLUNA DIREITA -->
  <aside class="checkout-direita">
    <input type="hidden" id="subtotal-value" value="<?= $subtotal ?>">

    <h2>Resumo do Pedido</h2>

    <div class="resumo-pedido">
      <p>
        <?= count($itensCarrinho) ?> ITENS 
        <span id="subtotal" data-valor="<?= number_format($subtotal, 2, '.', '') ?>">
          R$<?= number_format($subtotal, 2, ',', '.') ?>
        </span>
      </p>

      <p>
        Entrega 
        <span id="frete" data-valor="<?= number_format($frete, 2, '.', '') ?>">
          R$<?= number_format($frete, 2, ',', '.') ?>
        </span>
      </p>

      <p>
        Desconto 
        <span id="desconto" data-valor="<?= number_format($discount, 2, '.', '') ?>">
          R$<?= number_format($discount, 2, ',', '.') ?>
        </span>
      </p>

      <p class="total">
        <strong>
          Total 
          <span id="total" data-valor="<?= number_format($totalFinal, 2, '.', '') ?>">
            R$<?= number_format($totalFinal, 2, ',', '.') ?>
          </span>
        </strong>
      </p>

      <?php if ($cupomAplicado): ?>
        <p class="cupom-ok">Cupom aplicado: <?= htmlspecialchars($cupomAplicado, ENT_QUOTES) ?></p>
      <?php endif; ?>
    </div>

    <?php foreach ($itensCarrinho as $item): ?>
      <div class="detalhe">
        <img src="<?= htmlspecialchars($item['image_url'], ENT_QUOTES) ?>" alt="<?= htmlspecialchars($item['name'], ENT_QUOTES) ?>">
        <div>
          <h3><?= htmlspecialchars($item['name'], ENT_QUOTES) ?></h3>
          <p>Quantidade <?= (int)$item['quantity'] ?></p>
          <span>R$<?= number_format($item['sale_price'], 2, ',', '.') ?></span>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="desconto">
      <input 
        type="text" 
        id="cupom" 
        name="cupom" 
        form="" 
        placeholder="Cupom de desconto"
      >
      <button type="button" id="btn-aplicar-cupom">Aplicar</button>
    </div>
  </aside>
</main>

<footer>
  <!-- Benefícios -->
  <div class="beneficios-container">
    <div class="beneficio">
      <img src="../src/assets/image/entrega.svg" alt="Entrega">
      <div class="texto">
        <strong>Entrega expressa</strong>
        <span>a partir de 1 dia útil</span>
      </div>
    </div>

    <div class="beneficio">
      <img src="../src/assets/image/parcela.svg" alt="Parcelamento">
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
  </div>
</footer>

</body>
</html>
