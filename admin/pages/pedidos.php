
    <!-- Área principal -->
  
    <!-- ate aqui -->
     <section class="pedidos-header">
  <div class="pedidos-titulo">
    <h1>Lista de Pedidos</h1>
    <p class="breadcrumb">Home > Lista de Pedidos</p>
  </div>

  <div class="pedidos-filtros">
    <div class="data-filtro">
      <i class="fa-regular fa-calendar"></i> <!-- se usar FontAwesome -->
      <span>Maio 16, 2023 - Julho 16, 2023</span>
    </div>
   <div class="dropdown-status">
  <button class="alterar-status">Alterar status ▼</button>
  <ul class="dropdown-lista">
    <li>Entregue</li>
    <li>Cancelado</li>
    <li>Em processamento</li>
    <li>Pendente</li>
  </ul>
</div>
</section>

 <!-- Tabela de pedidos -->
    <section class="card pedidos">
      <h3>Pedidos Recentes</h3>
      <table>
        <thead>
          <tr>
            <th></th>
            <th>Produto</th>
            <th>ID Pedido</th>
            <th>Data</th>
            <th>Forma de Pagamento</th>
            <th>Nome do Cliente</th>
            <th>Status</th>
            <th>Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><input type="checkbox"></td>
            <td>Adidas Ultra Boost</td>
            <td>#5243</td>
            <td>Jan 06, 2025</td>
            <td>Pix</td>
            <td>Luiz Gouveia</td>
            <td><span class="status entregue">Entregue</span></td>
            <td>R$849,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Forum Exhibit Low</td>
            <td>#5245</td>
            <td>Jan 07, 2025</td>
            <td>Cartão</td>
            <td>Jessica Barros</td>
            <td><span class="status enviado">Enviado</span></td>
            <td>R$749,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>SL Running</td>
            <td>#5246</td>
            <td>Jan 08, 2025</td>
            <td>Boleto</td>
            <td>João Pereira</td>
            <td><span class="status entregue">Entregue</span></td>
            <td>R$599,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Air Max Pro</td>
            <td>#5247</td>
            <td>Jan 09, 2025</td>
            <td>Pix</td>
            <td>Marina Costa</td>
            <td><span class="status enviado">Enviado</span></td>
            <td>R$899,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Air Max Pro</td>
            <td>#5247</td>
            <td>Jan 09, 2025</td>
            <td>Boleto</td>
            <td>Marina Costa</td>
            <td><span class="status pendente">Pendente</span></td>
            <td>R$899,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Air Max Pro</td>
            <td>#5247</td>
            <td>Jan 09, 2025</td>
            <td>Cartão</td>
            <td>Marina Costa</td>
            <td><span class="status enviado">Enviado</span></td>
            <td>R$899,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Air Max Pro</td>
            <td>#5247</td>
            <td>Jan 09, 2025</td>
            <td>Cartão</td>
            <td>Marina Costa</td>
            <td><span class="status cancelado">Cancelado</span></td>
            <td>R$899,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Air Max Pro</td>
            <td>#5247</td>
            <td>Jan 09, 2025</td>
            <td>Pix</td>
            <td>Marina Costa</td>
            <td><span class="status processamento">Processamento</span></td>
            <td>R$899,00</td>
          </tr>
        </tbody>
      </table>
        <!-- Paginação -->
  <div class="paginacao">
    <button>&laquo;</button>
    <button class="ativo">1</button>
    <button>2</button>
    <button>3</button>
    <button>...</button>
    <button>Próximo &raquo;</button>
  </div>

