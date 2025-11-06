<?php

// CONEXÃO COM BANCO

include __DIR__ . '/../conexao.php';

// PARÂMETROS (GET)

$categoria = $_GET['cat'] ?? '';
$tamanho   = $_GET['tamanho'] ?? '';
$cor       = $_GET['cor'] ?? '';
$estilo    = $_GET['estilo'] ?? '';
$preco_max = $_GET['preco'] ?? '';
$page      = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$por_pagina = 12;
$inicio     = ($page - 1) * $por_pagina;

// MONTAGEM DA CONSULTA

$sql = "SELECT * FROM produtos WHERE 1";
$params = [];

// Categoria
if (!empty($categoria)) {
  $sql .= " AND categoria = ?";
  $params[] = $categoria;
}

// Tamanho
if (!empty($tamanho)) {
  $sql .= " AND tamanho = ?";
  $params[] = $tamanho;
}

// Cor
if (!empty($cor)) {
  $sql .= " AND cor = ?";
  $params[] = $cor;
}

// Estilo
if (!empty($estilo)) {
  $sql .= " AND estilo = ?";
  $params[] = $estilo;
}

// Preço máximo
if (!empty($preco_max)) {
  $sql .= " AND preco <= ?";
  $params[] = $preco_max;
}

// PAGINAÇÃO

$sqlCount = preg_replace('/SELECT \* FROM/', 'SELECT COUNT(*) FROM', $sql);
$stmtCount = $pdo->prepare($sqlCount);
$stmtCount->execute($params);
$total_itens = $stmtCount->fetchColumn();
$total_paginas = ceil($total_itens / $por_pagina);

// Busca produtos paginados
$sql .= " LIMIT $inicio, $por_pagina";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="../src/assets/css/lista-produtos.css">
     <script src="../src/assets/js/lista-produtos.js" defer></script>
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

 <div class="banner">
      <img src="../src/assets/image/banner.svg" alt="banner">
  </div>

  <!-- MENU LATERAL -->
  <aside class="menuLateral">
    <form method="GET" action="lista-produtos.php">
      <input type="hidden" name="cat" value="<?= htmlspecialchars($categoria) ?>">

      <div class="filtro">
        <h2>Filtro</h2>
        <h3>Escolher por:</h3>
      </div>

      <div class="tamanhos">
        <h3>Tamanhos</h3>
        <?php foreach (['P','M','G','GG','XL','2XL'] as $t): ?>
          <label>
            <input type="radio" name="tamanho" value="<?= $t ?>" <?= $t == $tamanho ? 'checked' : '' ?>> <?= $t ?>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="cores">
        <h3>Cor</h3>
        <?php
          $cores = [
            '#3d5afe'=>'Azul', '#ff9800'=>'Laranja', '#4caf50'=>'Verde',
            '#212121'=>'Preto', '#9e9e9e'=>'Cinza', 'white'=>'Branco',
            'red'=>'Vermelho', 'green'=>'Verde Escuro'
          ];
          foreach ($cores as $hex => $nome):
        ?>
          <label>
            <input type="radio" name="cor" value="<?= $nome ?>" <?= $nome == $cor ? 'checked' : '' ?>>
            <span style="background:<?= $hex ?>"></span>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="estilo">
        <h3>Estilo</h3>
        <?php foreach (['Casual','Corrida','Caminhada','Tênis','Basquete','Golf','Outdoor'] as $e): ?>
          <label>
            <input type="radio" name="estilo" value="<?= $e ?>" <?= $e == $estilo ? 'checked' : '' ?>> <?= $e ?>
          </label>
        <?php endforeach; ?>
      </div>

      <div class="preco">
        <h3>Preço Máximo</h3>
        <input type="range" min="0" max="2000" step="50" name="preco" value="<?= $preco_max ?: 2000 ?>">
        <span>Até R$ <?= $preco_max ?: '2000,00' ?></span>
      </div>

      <button type="submit" class="btn-filtrar">Filtrar</button>
    </form>
  </aside>

  <main>
      <h1><?= ucfirst($categoria ?: 'Produtos') ?></h1>
      <p><?= $total_itens ?> itens encontrados</p>

     <section class="Produtos">
    <?php if (!empty($produtos)): ?>
        <?php foreach ($produtos as $p): ?>
            <article class="product-card">
                <button class="fav" aria-label="Favoritar">♥</button>

                <!-- 🔹 LINK ENVOLVENDO A IMAGEM E OS DADOS DO PRODUTO -->
                <a href="pagina-produto.php?id=<?= urlencode($p['id']) ?>" class="link-produto">
                    <img src="<?= htmlspecialchars($p['imagem_url'] ?? '../src/assets/image/sem-foto.svg') ?>" 
                         alt="<?= htmlspecialchars($p['nome']) ?>">
                    <h3 class="title"><?= htmlspecialchars($p['nome']) ?></h3>
                    <p class="price">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                </a>

                <!-- 🔹 BOTÃO DE COMPRAR DIRETO PARA O CHECKOUT -->
                <form action="checkout.php" method="GET">
                    <input type="hidden" name="produto" value="<?= htmlspecialchars($p['id']) ?>">
                    <button type="submit" class="btn">COMPRAR</button>
                </form>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum produto encontrado para os filtros selecionados.</p>
    <?php endif; ?>
</section>
  </main>

  <div class="MudarPagina">
      <?php if ($page > 1): ?>
          <a href="?cat=<?= urlencode($categoria) ?>&page=<?= $page - 1 ?>">Anterior</a>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
          <a href="?cat=<?= urlencode($categoria) ?>&page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
              <?= $i ?>
          </a>
      <?php endfor; ?>

      <?php if ($page < $total_paginas): ?>
          <a href="?cat=<?= urlencode($categoria) ?>&page=<?= $page + 1 ?>">Próximo</a>
      <?php endif; ?>
  </div>

<footer>
    <!-- Benefícios -->
<div class="beneficios-container">
<div class="beneficio">
<img src="./image/relogio-frete.svg"alt="Entrega">
<div class="texto">
<strong>Entrega expressa</strong>
<span>a partir de 1 dia útil</span>
</div>
</div>

<div class="beneficio">
<img src=""alt="Parcelamento">
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
</html>
