<?php
require_once __DIR__ . '/../../conexao.php';

/* ===========================
   MAIS VENDIDOS
   =========================== */
$maisQuery = $pdo->query("
    SELECT 
        p.id,
        p.nome,
        p.preco_venda,
        (SELECT caminho FROM produto_imagens WHERE produto_id = p.id ORDER BY ordenacao ASC LIMIT 1) AS imagem,
        COALESCE(SUM(pi.quantidade),0) AS total_vendido
    FROM pedido_itens pi
    INNER JOIN produtos p ON p.id = pi.produto_id
    GROUP BY p.id
    ORDER BY total_vendido DESC
    LIMIT 5
");
$maisVendidos = $maisQuery->fetchAll(PDO::FETCH_ASSOC);

/* ===========================
   PEDIDOS RECENTES
   =========================== */
$recentQuery = $pdo->query("
    SELECT 
        o.id AS pedido_id,
        o.usuario_id,
        u.nome AS cliente,
        o.status,
        o.valor_total AS total,
        o.criado_em
    FROM pedidos o
    LEFT JOIN usuarios u ON u.id = o.usuario_id
    ORDER BY o.id DESC
    LIMIT 8
");
$pedidos = $recentQuery->fetchAll(PDO::FETCH_ASSOC);

/* ===========================
   GRÁFICO PIZZA (STATUS)
   =========================== */
$totais = $pdo->query("
    SELECT 
        SUM(status = 'pago') AS pagos,
        SUM(status = 'enviado') AS enviados,
        SUM(status = 'entregue') AS entregues,
        SUM(status = 'cancelado') AS cancelados,
        SUM(status = 'pendente') AS pendentes
    FROM pedidos
")->fetch(PDO::FETCH_ASSOC);

$pieLabels = ['Pago','Enviado','Entregue','Cancelado','Pendente'];
$pieData = [
    (int)$totais['pagos'],
    (int)$totais['enviados'],
    (int)$totais['entregues'],
    (int)$totais['cancelados'],
    (int)$totais['pendentes']
];

/* ===========================
   GRÁFICO DE LINHA
   =========================== */
$anoAtual = date('Y');
$lineLabels = [];
$lineData = [];

$stm = $pdo->prepare("
    SELECT IFNULL(SUM(valor_total),0) AS soma
    FROM pedidos
    WHERE MONTH(criado_em) = ? AND YEAR(criado_em) = ?
");
for($m=1; $m<=12; $m++){
    $lineLabels[] = date('M', mktime(0,0,0,$m,1));
    $stm->execute([$m,$anoAtual]);
    $lineData[] = (float)($stm->fetchColumn() ?? 0);
}

/* ===========================
   Função Avatar (iniciais)
   =========================== */
function avatar_initials($name){
    $parts = explode(' ', trim($name));
    $i = strtoupper($parts[0][0] ?? '?');
    $j = strtoupper($parts[1][0] ?? '');
    return $i.$j;
}
?>

<!-- =============== VARIÁVEIS PARA O JS =============== -->
<script>
    const pieLabels        = <?= json_encode($pieLabels) ?>;
    const pieData          = <?= json_encode($pieData) ?>;
    const lineLabels       = <?= json_encode($lineLabels) ?>;
    const lineData         = <?= json_encode($lineData) ?>;
    const maisVendidos     = <?= json_encode($maisVendidos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const pedidosRecentes  = <?= json_encode($pedidos, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>

<!-- =============== LINK DO CSS =============== -->
<link rel="stylesheet" href="pages/dashboard.css">

<!-- =============== HTML DO DASHBOARD =============== -->
<div class="dashboard-wrap">

    <div class="top-row">

        <!-- DONUTS -->
        <div class="card graph-card">
            <h3>Gráfico Geral</h3>

            <div class="donuts-row">
                <div class="donut-item">
                    <canvas id="donut1"></canvas>
                    <div class="donut-label">Pedidos Pagos</div>
                </div>
                <div class="donut-item">
                    <canvas id="donut2"></canvas>
                    <div class="donut-label">Pedidos Enviados</div>
                </div>
                <div class="donut-item">
                    <canvas id="donut3"></canvas>
                    <div class="donut-label">Pedidos Entregues</div>
                </div>
            </div>
        </div>

        <!-- MAIS VENDIDOS -->
        <aside class="card top-sellers">
            <h3>Mais Vendidos</h3>

            <ul id="lista-vendidos">
                <?php foreach($maisVendidos as $m): ?>
                    <li>
                        <img src="<?= $m['imagem'] ?: 'uploads/placeholder.png' ?>">
                        <div class="info">
                            <div class="nome"><?= htmlspecialchars($m['nome']) ?></div>
                            <div class="meta">
                                R$<?= number_format($m['preco_venda'],2,',','.') ?> — <?= $m['total_vendido'] ?> vendidos
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <button class="relatorio">RELATÓRIO</button>
        </aside>

    </div>

    <!-- GRÁFICO LINHA -->
    <div class="card line-card">
        <h3>Vendas ao Mês (<?= $anoAtual ?>)</h3>
        <canvas id="graficoLinha"></canvas>
    </div>

    <!-- PEDIDOS RECENTES -->
    <div class="card pedidos-card">
        <h3>Pedidos Recentes</h3>

        <table class="pedidos-table">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Cliente</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($pedidos as $p): ?>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>#<?= $p['pedido_id'] ?></td>
                    <td><?= date("d/m/Y H:i", strtotime($p['criado_em'])) ?></td>

                    <td>
                        <div class="cliente">
                            <div class="avatar"><?= avatar_initials($p['cliente']) ?></div>
                            <div><?= htmlspecialchars($p['cliente']) ?></div>
                        </div>
                    </td>

                    <td><span class="status <?= strtolower($p['status']) ?>"><?= ucfirst($p['status']) ?></span></td>
                    <td>R$<?= number_format($p['total'],2,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>
    </div>

</div>

<!-- =============== SCRIPT DO DASHBOARD =============== -->
<script src="pages/dashboard.js"></script>
<script>
window.lineLabels = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];

window.lineData = [120, 150, 180, 160, 210, 190, 240, 260, 280, 300, 330, 350];

window.pieData = [81, 22, 62]; // exemplo
</script>
