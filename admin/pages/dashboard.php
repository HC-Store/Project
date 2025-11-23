<?php
require_once __DIR__ . '/../../conexao.php';

/* =============================
   MAIS VENDIDOS
============================= */
$maisQuery = $pdo->query("
    SELECT 
        p.nome AS produto,
        pi.preco AS preco,
        (
            SELECT caminho 
            FROM produto_imagens 
            WHERE produto_id = p.id 
            ORDER BY ordenacao ASC 
            LIMIT 1
        ) AS imagem,
        SUM(pi.quantidade) AS total_vendido
    FROM pedido_itens pi
    INNER JOIN produtos p ON p.id = pi.produto_id
    GROUP BY pi.produto_id
    ORDER BY total_vendido DESC
    LIMIT 3
");
$maisVendidos = $maisQuery->fetchAll();

/* =============================
   PEDIDOS RECENTES
============================= */
$recentQuery = $pdo->query("
    SELECT 
        p.id AS pedido_id,
        c.nome AS cliente,
        p.status,
        p.total,
        p.created_at
    FROM pedidos p
    INNER JOIN clientes c ON c.id = p.cliente_id
    ORDER BY p.id DESC
    LIMIT 10
");
$pedidos = $recentQuery->fetchAll();

/* =============================
   GRÁFICO PIZZA
============================= */
$totais = $pdo->query("
    SELECT 
        SUM(status = 'pago') AS pagos,
        SUM(status = 'enviado') AS enviados,
        SUM(status = 'cancelado') AS cancelados
    FROM pedidos
")->fetch();

$pieLabels = ['Pagos', 'Enviados', 'Cancelados'];
$pieData = [
    (int)$totais['pagos'],
    (int)$totais['enviados'],
    (int)$totais['cancelados']
];

/* =============================
   GRÁFICO DE LINHA
============================= */
$anoAtual = date('Y');
$lineLabels = [];
$lineData = [];

for ($m = 1; $m <= 12; $m++) {
    $lineLabels[] = date("M", mktime(0, 0, 0, $m, 1));

    $stm = $pdo->prepare("
        SELECT SUM(total) AS soma
        FROM pedidos
        WHERE MONTH(created_at) = ? AND YEAR(created_at) = ?
    ");
    $stm->execute([$m, $anoAtual]);
    $row = $stm->fetch();

    $lineData[] = $row['soma'] ? (float)$row['soma'] : 0;
}

/* =============================
   STATUS CLASS
============================= */
function status_class($s){
    return match(strtolower($s)){
        'pago'      => 'entregue',
        'enviado'   => 'enviado',
        'cancelado' => 'cancelado',
        default     => 'pendente'
    };
}
?>
<!doctype html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard</title>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Variáveis para o JS -->
  <script>
    const pieLabels = <?= json_encode($pieLabels) ?>;
    const pieData   = <?= json_encode($pieData) ?>;
    const lineLabels = <?= json_encode($lineLabels) ?>;
    const lineData   = <?= json_encode($lineData) ?>;
  </script>

  <!-- CSS CORRETO -->
  <link rel="stylesheet" href="./pages/dashboard.css">

</head>

<body>

  <div class="container">
    <h1 class="page-title">Dashboard</h1>

    <!-- CARDS SUPERIORES -->
    <section class="painel-cards">

      <!-- GRÁFICO PIZZA -->
      <div class="card grafico">
        <h3>Gráfico Geral</h3>
        <canvas id="graficoPizza"></canvas>
      </div>

      <!-- MAIS VENDIDOS -->
      <div class="card mais-vendidos">
        <h3>Mais Vendidos</h3>
        <ul>
          <?php if(empty($maisVendidos)): ?>
            <li>Nenhum produto vendido</li>

          <?php else: foreach($maisVendidos as $m): ?>
              <li>
                <img src="<?= $m['imagem'] ? '../../uploads/' . $m['imagem'] : 'placeholder.png' ?>" 
                     style="width:45px; border-radius:8px" alt="">
                <span><?= htmlspecialchars($m['produto']) ?></span>
                <strong>R$<?= number_format($m['preco'], 2, ',', '.') ?></strong>
              </li>
          <?php endforeach; endif; ?>
        </ul>
        <button class="relatorio">Relatório</button>
      </div>

    </section>

    <!-- GRÁFICO DE LINHA -->
    <section class="grafico-linha card">
      <h3>Vendas ao Mês</h3>
      <canvas id="graficoLinha"></canvas>
    </section>

    <!-- TABELA DE PEDIDOS -->
    <section class="card pedidos">
      <h3>Pedidos Recentes</h3>

      <table>
        <thead>
          <tr>
            <th></th>
            <th>Nº Pedido</th>
            <th>Data</th>
            <th>Cliente</th>
            <th>Status</th>
            <th>Total</th>
          </tr>
        </thead>

        <tbody>
        <?php if(empty($pedidos)): ?>
            <tr><td colspan="6">Nenhum pedido encontrado.</td></tr>

        <?php else: foreach($pedidos as $p): ?>
          <tr>
            <td><input type="checkbox"></td>

            <td>#<?= $p['pedido_id'] ?></td>

            <td><?= date("d/m/Y H:i", strtotime($p['created_at'])) ?></td>

            <td><?= htmlspecialchars($p['cliente']) ?></td>

            <td>
              <span class="status <?= status_class($p['status']) ?>">
                <?= ucfirst($p['status']) ?>
              </span>
            </td>

            <td>R$<?= number_format($p['total'], 2, ',', '.') ?></td>
          </tr>
        <?php endforeach; endif; ?>
        </tbody>

      </table>
    </section>

  </div>

  <!-- JS CORRETO -->
  <script src="./pages/dashboard.js"></script>

</body>
</html>
