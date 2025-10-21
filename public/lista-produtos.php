<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="/src/assets/pages/lista-de-Produtos/style.css">
</head>
<body>
 <header>
        <div class="container">
        <input type="text" placeholder="O que você deseja ?">
        <img src="/src/assets/image/logo da loja.svg" alt="logo loja">
        <nav class="icons">
            <a href=""><img src="/src/assets/image/Coração.svg" alt="coraçao"></a>
            <a href=""><img src="/src/assets/image/Sacola.svg" alt="Sacola"></a>
            <a href=""><img src="/src/assets/image/Login.svg" alt="login"></a>
        </nav>
        </div>
     <nav class="menu">
        <ul>
          <li><a href="#">Acessórios</a></li>
          <li><a href="#">Calçados</a></li>
          <li><a href="#">Perfumes</a></li>
          <li><a href="#">Roupas</a></li>
          <li><a href="#">Moda Casual</a></li>
          <li><a href="#">Moda Íntima</a></li>
          <li><a href="#">Ofertas</a></li>
        </ul>
      </nav>
    </header>
                
    
    <div class="banner">
        <img src="/src/assets/image/banner.svg" alt="banner">
    </div>
    
<section class="menuLateral">
    
    <div class="filtro">
        <h2>Filtro</h2>
        <h3>Escolher por:</h3>
        <button></button>
    </div>
    
    <div class="tamanhos">
        <h3>Tamanhos</h3>
        <button>M</button>
        <button>G</button>
        <button>GG</button>
        <button>XL</button>
        <button>2XL</button>
    </div>
   
    <div class="cores">
       <h3>Cor</h3>
      <span style="background:#3d5afe"></span>
      <span style="background:#ff9800"></span>
      <span style="background:#4caf50"></span>
      <span style="background:#212121"></span>
      <span style="background:#9e9e9e"></span>
      <span style="background:white"></span>
      <span style="background:red"></span>
      <span style="background:green"></span>
    </div>
    
    <div class="estilo">
    <h3>Estilo</h3>
    <label><input type="checkbox"> Casual</label>
    <label><input type="checkbox"> Corrida</label>
    <label><input type="checkbox"> Caminhada</label>
    <label><input type="checkbox"> Tênis</label>
    <label><input type="checkbox"> Basquete</label>
    <label><input type="checkbox"> Golf</label>
    <label><input type="checkbox"> Outdoor</label>
    </div>
    
    <h3>Preço</h3>
    <input type="range" min="0" max="2000" step="50" >

</section>

<main>
     <h1>Roupas</h1>
     <p>200itens</p>
     <button></button>
    
<section class="Produtos">
    <article class="">
        <img src="/src/assets/image/blusa.svg" alt="Roupas">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
    
    <article>
        <img src="/src/assets/image/blusa.svg" alt="">
        <h3>Conjunto Puma <br>Vermelho</h3>
        <p>R$199,99</p>
        <button>COMPRAR</button>
    </article>
</section>
</main>
<div class="MudarPagina">
    <a href="">Anterior</a>
    <a href="">1</a>
    <a href="">2</a>
    <a href="">3</a>
    <a href="">4</a>
    <span>....</span>
    <a href="">10</a>
    <a href="">Próximo</a>
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
