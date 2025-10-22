   
<!-- Título da página -->
    <h1 class="page-title">Dashboard</h1>

    <!-- Painéis superiores -->
    <section class="painel-cards">
      <!-- Gráfico Pizza -->
      <div class="card grafico">
        <h3>Gráfico Geral</h3>
        <canvas id="graficoPizza"></canvas>
      </div>

      <!-- Painel Mais Vendidos -->
      <div class="card mais-vendidos">
        <h3>Mais Vendidos</h3>
        <ul>
          <li>
            <img src="../src/assets/image/conjadm.svg" alt="">
            <span>Conjunto EA7</span>
            <strong>R$849,00</strong>
          </li>
          <li>
            <img src="../src/assets/image/adidastenis.svg" alt="">
            <span>Adidas Campos</span>
            <strong>R$749,00</strong>
          </li>
          <li>
            <img src="../src/assets/image/conjadm.svg" alt="">
            <span>Conjunto EA7</span>
            <strong>R$599,00</strong>
          </li>
        </ul>
        <button class="relatorio">Relatório</button>
      </div>
    </section>

    <!-- Gráfico de linha (largura total) -->
    <section class="grafico-linha">
      <h3>Vendas ao Mês</h3>
      <canvas id="graficoLinha"></canvas>
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
            <td>Luiz Gouveia</td>
            <td><span class="status entregue">Entregue</span></td>
            <td>R$849,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Forum Exhibit Low</td>
            <td>#5245</td>
            <td>Jan 07, 2025</td>
            <td>Jessica Barros</td>
            <td><span class="status enviado">Enviado</span></td>
            <td>R$749,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>SL Running</td>
            <td>#5246</td>
            <td>Jan 08, 2025</td>
            <td>João Pereira</td>
            <td><span class="status entregue">Entregue</span></td>
            <td>R$599,00</td>
          </tr>
          <tr>
            <td><input type="checkbox"></td>
            <td>Air Max Pro</td>
            <td>#5247</td>
            <td>Jan 09, 2025</td>
            <td>Marina Costa</td>
            <td><span class="status enviado">Enviado</span></td>
            <td>R$899,00</td>
          </tr>
        </tbody>
      </table>
    </section>



