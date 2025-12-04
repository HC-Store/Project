<!-- HTML + CSS + JS + PHP UNIFICADO PARA LISTA DE PEDIDOS -->

<!-- ================== PHP CONEXÃO ================== -->
<?php
require_once __DIR__ . '/../../conexao.php';

$pedidos = $pdo->query("
    SELECT 
        p.id,
        p.valor_total AS valor,
        p.status,
        p.criado_em,

        u.nome AS cliente,

        pg.metodo_pagamento AS pagamento,

        (
            SELECT pr.nome 
            FROM pedido_itens pi 
            JOIN produtos pr ON pr.id = pi.produto_id
            WHERE pi.pedido_id = p.id LIMIT 1
        ) AS produto

    FROM pedidos p
    LEFT JOIN usuarios u ON u.id = p.usuario_id
    LEFT JOIN pagamentos pg ON pg.pedido_id = p.id
    ORDER BY p.id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Lista de Pedidos</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
<style>
/* ================== ESTILO BASE ================== */
body {
  font-family: "Inter", sans-serif;
  background: #f5f5f5;
  margin: 0;
  padding: 20px;
  color: #333;
}

h1, h3 { margin: 0; }

.card {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  margin-top: 20px;
}

/* ================== HEADER ================== */
.pedidos-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.pedidos-titulo p {
  color: #777;
  font-size: 14px;
}

.data-filtro {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #fff;
  padding: 10px 15px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  cursor: pointer;
}

/* ================== DROPDOWN ================== */
.dropdown-status {
  position: relative;
}

.alterar-status {
  background: #fff;
  padding: 10px 15px;
  border-radius: 8px;
  border: none;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  cursor: pointer;
}

.dropdown-lista {
  position: absolute;
  top: 45px;
  right: 0;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  list-style: none;
  padding: 10px 0;
  width: 160px;
  display: none;
}

.dropdown-lista li {
  padding: 10px 15px;
  cursor: pointer;
}

.dropdown-lista li:hover {
  background: #f0f0f0;
}

/* ================== TABELA ================== */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th {
  text-align: left;
  padding: 12px;
  color: #777;
  font-size: 14px;
}

td {
  padding: 15px;
  border-top: 1px solid #eee;
  font-size: 15px;
}

/* ================== STATUS BADGES ================== */
.status {
  padding: 6px 12px;
  border-radius: 20px;
  color: #fff;
  font-size: 13px;
}

.entregue { background: #3CB371; }
.enviado { background: #1E90FF; }
.cancelado { background: #FF6347; }
.pendente { background: #FFA500; }
.processamento { background: #9370DB; }

/* ================== PAGINAÇÃO ================== */
.paginacao {
  margin-top: 20px;
  display: flex;
  gap: 8px;
}

.paginacao button {
  padding: 8px 14px;
  border: none;
  border-radius: 6px;
  background: #fff;
  cursor: pointer;
  box-shadow: 0 2px 6px rgba(0,0,0,0.05);
}

.paginacao .ativo {
  background: #000;
  color: #fff;
}
</style>
</head>
<body>

<section class="pedidos-header">
  <div class="pedidos-titulo">
    <h1>Lista de Pedidos</h1>
    <p>Home > Lista de Pedidos</p>
  </div>

  <div class="pedidos-filtros">
    <div class="data-filtro">
      <i class="fa-regular fa-calendar"></i>
      <span>Maio 16, 2023 - Julho 16, 2023</span>
    </div>

    <div class="dropdown-status">
      <button class="alterar-status">Alterar Status ▼</button>
      <ul class="dropdown-lista">
  <li onclick="alterarStatus('Entregue')">Entregue</li>
  <li onclick="alterarStatus('Enviado')">Enviado</li>
  <li onclick="alterarStatus('Cancelado')">Cancelado</li>
  <li onclick="alterarStatus('Pendente')">Pendente</li>
  <li onclick="alterarStatus('Processamento')">Processamento</li>
</ul>

    </div>
  </div>
</section>

<section class="card pedidos">
  <h3>Pedidos Recentes</h3>
  <table>
    <thead>
      <tr data-id="<?= $p['id'] ?>">
        <th></th>
        <th>Produto</th>
        <th>ID Pedido</th>
        <th>Data</th>
        <th>Forma de Pagamento</th>
        <th>Cliente</th>
        <th>Status</th>
        <th>Valor</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pedidos as $p): ?>
    <tr data-id="<?= $p['id'] ?>">
        <td><input type="checkbox"></td>
        <td><?= $p['produto'] ?></td>
        <td>#<?= $p['id'] ?></td>
        <td><?= $p['criado_em'] ?></td>
        <td><?= $p['pagamento'] ?></td>
        <td><?= $p['cliente'] ?></td>
        <td><span class="status <?= strtolower($p['status']) ?>"><?= ucfirst($p['status']) ?></span></td>
        <td>R$<?= number_format($p['valor'], 2, ',', '.') ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <div class="paginacao">
    <button>&laquo;</button>
    <button class="ativo">1</button>
    <button>2</button>
    <button>3</button>
    <button>...</button>
    <button>Próximo &raquo;</button>
  </div>
</section>

<script>
// Dropdown
const btnStatus = document.querySelector('.alterar-status');
const menu = document.querySelector('.dropdown-lista');

btnStatus.onclick = () => {
  menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
};

document.addEventListener('click', (e) => {
  if (!btnStatus.contains(e.target) && !menu.contains(e.target)) {
    menu.style.display = 'none';
  }
});

function alterarStatus(status) {

    // encontra qual pedido está selecionado
    const check = document.querySelector("tbody input[type='checkbox']:checked");

    if (!check) {
        alert("Selecione um pedido para alterar o status!");
        return;
    }

    const row = check.closest("tr");
    const id = row.getAttribute("data-id");

    // AJAX para alterar no banco
    fetch("pages/pedidos_action.php", {
        method: "POST",
        body: new URLSearchParams({
            action: "alterar_status",
            id: id,
            status: status
        })
    })
    .then(r => r.json())
    .then(json => {
        if (json.success) {
            // muda visualmente na tela
            row.querySelector(".status").textContent = status;
            row.querySelector(".status").className = "status " + status.toLowerCase();
            alert("Status atualizado para: " + status);
        } else {
            alert("Erro: " + json.message);
        }
    });
}

</script>

</body>
</html>
