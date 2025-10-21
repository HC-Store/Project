<section class="product-details">
  <h1>Detalhes do Produto</h1>
  <h2>Home > Todos os Produtos > Adicionar Novo Produto</h2>

  <div class="product-container">
    <!-- COLUNA ESQUERDA -->
    <div class="form-column">
      <div class="field">
        <h3>Nome do Produto</h3>
        <input type="text" placeholder="Digite o nome aqui">
      </div>

      <div class="field">
        <h3>Descrição</h3>
        <textarea placeholder="Digite a descrição aqui"></textarea>
      </div>

      <div class="field">
        <h3>Categoria</h3>
        <input type="text" placeholder="Type Category here">
      </div>

      <div class="field">
        <h3>Marca</h3>
        <input type="text" placeholder="Type brand name here">
      </div>

      <div class="field-row">
        <div class="field">
          <h3>Número Estoque</h3>
          <input type="text" placeholder="Fox-3983">
        </div>
        <div class="field">
          <h3>Quantidade em Estoque</h3>
          <input type="text" placeholder="1258">
        </div>
      </div>

      <div class="field-row">
        <div class="field">
          <h3>Preço Normal</h3>
          <input type="text" placeholder="R$100">
        </div>
        <div class="field">
          <h3>Preço de Venda</h3>
          <input type="text" placeholder="R$450">
        </div>
      </div>

      <div class="field">
        <h3>Tag</h3>
        <div class="botoes-conteiner">
          <button>Adidas</button>
          <button>Shoes</button>
          <button>Sneakers</button>
          <button>Ultraboost</button>
        </div>
      </div>
    </div>

    <!-- COLUNA DIREITA -->
    <div class="gallery-column">
      <div class="product-set">
        <img src="./src/assets/image/conj-ea7.svg" alt="Produto Principal">
      </div>

      <div class="gallery">
        <h3>Galeria de Produtos</h3>
        <div class="square">
          <div class="gallery-foto">
            <img src="./src/assets/image/foto.svg" alt="Upload">
          </div>
          <p>Drop your image here, or browse<br>Jpeg, png are allowed</p>
        </div>

        <div class="upload-list">
          <div class="upload-item">
            <img src="./src/assets/image/product-thumbnail.svg" alt="">
            <div class="info">
              <p>Product thumbnail.png</p>
              <div class="progress"><div class="progress-bar"></div></div>
            </div>
            <div class="check"><img src="./src/assets/image/azul.svg" alt=""></div>
          </div>
          <div class="upload-item">
            <img src="./src/assets/image/product-thumbnail.svg" alt="">
            <div class="info">
              <p>Product thumbnail.png</p>
              <div class="progress"><div class="progress-bar"></div></div>
            </div>
            <div class="check"><img src="./src/assets/image/azul.svg" alt=""></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="botoes-edit">
    <button class="to-add">ADICIONAR</button>
    <button class="delete">APAGAR</button>
    <button class="cancel">CANCELAR</button>
  </div>
</section>

