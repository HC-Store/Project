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
          <h3 class="dropdown-title">Favoritos (0)</h3>
          <div class="dropdown-content" id="fav-content"></div>
          <button class="dropdown-btn black" id="btn-continuar-fav">CONTINUAR COMPRANDO</button>
        </div>
      </div>

      <!-- 🛍️ SACOLA -->
      <div class="user-menu">
        <button class="icon-btn" id="bag-icon">
          <img src="../src/assets/image/Sacola.svg" alt="Sacola">
        </button>
        <div class="dropdown-panel" id="bag-dropdown">
          <h3 class="dropdown-title">Minha sacola (0)</h3>
          <div class="dropdown-content" id="bag-content">
            <p class="empty-msg">Sua sacola está vazia</p>
          </div>
          <button class="dropdown-btn pagamento black" id="btn-pagamento">PAGAMENTO</button>
          <button class="dropdown-btn secondary black" id="btn-voltar">CONTINUAR COMPRANDO</button>
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
   <?php if (!empty($mostrarMenu) && $mostrarMenu): ?>
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
  <?php endif; ?>
</header>

<!-- ====== CATEGORIAS ====== -->
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

<section class="categorias" id="cat-calcados">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Tênis</a>
    <a href="lista-produtos.php">Sapatênis</a>
    <a href="lista-produtos.php">Chinelo</a>
    <a href="lista-produtos.php">Bota</a>
    <a href="lista-produtos.php">Sandália</a>
  </div>
</section>

<section class="categorias" id="cat-perfumes">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Importados</a>
    <a href="lista-produtos.php">Amadeirados</a>
    <a href="lista-produtos.php">Doces</a>
    <a href="lista-produtos.php">Frescos</a>
  </div>
</section>

<section class="categorias" id="cat-roupas">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Camisetas</a>
    <a href="lista-produtos.php">Moletom</a>
    <a href="lista-produtos.php">Calças</a>
    <a href="lista-produtos.php">Shorts</a>
    <a href="lista-produtos.php">Conjuntos</a>
  </div>
</section>

<section class="categorias" id="cat-casual">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Camisas</a>
    <a href="lista-produtos.php">Polos</a>
    <a href="lista-produtos.php">Bermudas</a>
  </div>
</section>

<section class="categorias" id="cat-intima">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Cuecas</a>
    <a href="lista-produtos.php">Meias</a>
    <a href="lista-produtos.php">Pijamas</a>
  </div>
</section>

<section class="categorias" id="cat-ofertas">
  <div class="categorias-grid">
    <a href="lista-produtos.php">Promoções</a>
    <a href="lista-produtos.php">Descontos</a>
    <a href="lista-produtos.php">Outlet</a>
  </div>
</section>

<!-- ====== POPUPS ====== -->
<section class="popup" id="popup-login">
  <form class="login" id="form-login">
    <h2>Login</h2>
    <label>CPF OU E-MAIL</label>
    <input type="text" name="login" placeholder="Digite seu CPF ou E-Mail">
    <label>SENHA</label>
    <input type="password" name="password" placeholder="Digite sua Senha">
    <button type="submit" class="btn-entrar">ENTRAR</button>
    <div class="links">
      <a href="#" id="link-criar">CRIAR UMA CONTA?</a>
      <a href="#">ESQUECI MINHA SENHA</a>
    </div>
  </form>
</section>

<section class="popup" id="popup-criar">
  <form class="container-criar" id="form-criar">
    <h2>Criar Conta</h2>

    <div class="formulario">
      <div class="coluna">
        <label>Nome</label>
        <input type="text" name="name" placeholder="Nome*">
        <small class="field-error" data-err="name"></small>

        <label>Sobrenome</label>
        <input type="text" name="sobrenome" placeholder="Sobrenome*">

        <label>CPF</label>
        <input type="text" name="cpf" placeholder="CPF*">
        <small class="field-error" data-err="cpf"></small>

        <label>Data de Nascimento</label>
        <input type="date" name="nascimento">
      </div>

      <div class="coluna">
        <label>E-mail</label>
        <input type="text" name="email" placeholder="E-mail*">
        <small class="field-error" data-err="email"></small>

        <label>Celular</label>
        <input type="text" name="phone" placeholder="Celular*">
        <small class="field-error" data-err="phone"></small>

        <label>Senha</label>
        <input type="password" name="password" placeholder="Senha*">
        <small class="field-error" data-err="password"></small>

        <a href="#" id="link-login">JÁ POSSUI UMA CONTA?</a>
      </div>
    </div>

    <button type="submit" class="botao black">Criar Conta</button>
    <small class="field-error" data-err="general"></small>
  </form>
</section>