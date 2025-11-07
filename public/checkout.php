<?php
// CONEXÃO COM O BANCO

include '../../conexao.php';

// Caso o banco ainda não exista, criamos dados fictícios:
$itensCarrinho = [
  [
    'nome' => 'DROPSET TRAINER SHOES',
    'preco' => 130.00,
    'quantidade' => 1,
    'tamanho' => 42,
    'imagem' => '../src/assets/image/conjunto.svg'
  ],
  [
    'nome' => 'Camiseta Empório Armani EA7',
    'preco' => 99.99,
    'quantidade' => 1,
    'tamanho' => 'M',
    'imagem' => '../src/assets/image/modelo.svg.svg'
  ]
];

// Caso queira futuramente puxar do banco, substituir este bloco por:
// $query = "SELECT nome, preco, quantidade, tamanho, imagem FROM carrinho WHERE id_cliente = ?";
// $stmt = $conn->prepare($query);
// $stmt->bind_param('i', $id_cliente);
// $stmt->execute();
// $itensCarrinho = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


// CÁLCULOS BÁSICOS (SUBTOTAL + FRETE)

$subtotal = 0;
foreach ($itensCarrinho as $item) {
  $subtotal += $item['preco'] * $item['quantidade'];
}

$frete = 6.99;
$totalFinal = $subtotal + $frete;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Check-Out</title>
  <link rel="stylesheet" href="../src/assets/css/checkout.css">
  <script src="../src/assets/js/checkout.js" defer></script>
</head>
<body>

  <header>
    <div class="container">
      <input type="text" placeholder="O que você deseja ?">
      <img src="/src/assets/image/logo da loja.svg" alt="Logo" class="logo">

      <nav class="icons">
        <!-- FAVORITOS -->
        <div class="user-menu">
          <button class="icon-btn" id="fav-icon">
            <img src="../src/assets/image/Coração.svg" alt="Favoritos">
          </button>
          <div class="dropdown-panel" id="fav-dropdown">
            <h3>FAVORITOS</h3>
            <div class="conteudo-fav">
              <div class="produto-exemplo">
                <img src="../src/assets/image/modelo.svg.svg" alt="Produto">
                <div class="produto-info">
                  <strong>Camiseta Nike</strong>
                  <span>R$ 149,99</span>
                </div>
              </div>
            </div>
            <button class="btn-acao">CONTINUAR COMPRANDO</button>
          </div>
        </div>

        <!-- SACOLA -->
        <div class="user-menu">
          <button class="icon-btn" id="bag-icon">
            <img src="../src/assets/image/Sacola.svg" alt="Sacola">
          </button>
          <div class="dropdown-panel" id="bag-dropdown">
            <h3>MINHA SACOLA (<?= count($itensCarrinho) ?>)</h3>
            <div class="conteudo-fav">
              <?php foreach ($itensCarrinho as $item): ?>
              <div class="produto-exemplo">
                <img src="<?= $item['imagem'] ?>" alt="<?= $item['nome'] ?>">
                <div class="produto-info">
                  <strong><?= $item['nome'] ?></strong>
                  <span>R$ <?= number_format($item['preco'], 2, ',', '.') ?></span>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
            <div class="botoes-sacola">
              <button class="btn-pagamento">PAGAMENTO</button>
              <button class="btn-acao" id="btn-voltar">CONTINUAR COMPRANDO</button>
            </div>
          </div>
        </div>

        <!-- LOGIN -->
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

  <!-- = POPUPS  -->
  <!-- LOGIN -->
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

  <!-- CRIAR CONTA -->
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

  <!--  CHECKOUT  -->
  <main class="checkout">
    <!-- COLUNA ESQUERDA -->
    <section class="checkout-esquerda">
      <form class="form checkout-left">
        <h1 class="titulo">Contato</h1>
        <p class="section-subtitle">Usaremos essa forma de contato para manter você informado sobre o pedido</p>

        <label for="email">Digite seu Email*</label>
        <input type="email" id="email" name="email" required>

        <label for="telefone">Número de Telefone</label>
        <input type="tel" id="telefone" name="telefone" required>

        <h1 class="titulo">Endereço de Envio</h1>

        <div class="form-linha">
          <div>
            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>
          </div>
          <div>
            <label for="sobrenome">Sobrenome</label>
            <input type="text" id="sobrenome" name="sobrenome" required>
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
        <input type="text" id="endereco" name="endereco" readonly>

        <label for="bairro">Bairro</label>
        <input type="text" id="bairro" name="bairro" readonly>

        <label for="cidade">Cidade</label>
        <input type="text" id="cidade" name="cidade" readonly>

        <label for="estado">Estado</label>
        <input type="text" id="estado" name="estado" readonly>

        <div class="form-linha">
          <div>
            <label for="complemento">Apart ou Casa</label>
            <input type="text" id="complemento" name="complemento">
          </div>
          <div>
            <label for="numero">Número</label>
            <input type="number" id="numero" name="numero">
          </div>
        </div>

        <button type="submit" class="btn-finalizar">Finalizar Pedido</button>
      </form>
    </section>

    <!-- COLUNA DIREITA -->
    <aside class="checkout-direita">
      <h2>Resumo do Pedido</h2>
      <div class="resumo-pedido">
        <p><?= count($itensCarrinho) ?> ITENS <span>R$<?= number_format($subtotal, 2, ',', '.') ?></span></p>
        <p>Entrega <span>R$<?= number_format($frete, 2, ',', '.') ?></span></p>
        <p>Taxas <span>R$0,00</span></p>
        <p class="total"><strong>Total <span>R$<?= number_format($totalFinal, 2, ',', '.') ?></span></strong></p>
      </div>

      <?php foreach ($itensCarrinho as $item): ?>
      <div class="detalhe">
        <img src="<?= $item['imagem'] ?>" alt="<?= $item['nome'] ?>">
        <div>
          <h3><?= $item['nome'] ?></h3>
          <p>Tamanho <?= $item['tamanho'] ?> — Quantidade <?= $item['quantidade'] ?></p>
          <span>R$<?= number_format($item['preco'], 2, ',', '.') ?></span>
        </div>
      </div>
      <?php endforeach; ?>

      <div class="desconto">
        <input type="text" placeholder="Cupom de desconto">
        <button type="button">Aplicar</button>
      </div>
    </aside>
  </main>

</body>
</html>
