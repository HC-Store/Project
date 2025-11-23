<!-- HTML + CSS + JS + PHP UNIFICADO PARA LISTA DE PEDIDOS -->

<!-- ================== PHP CONEXÃO ================== -->
<?php
$host = "localhost";
$user = "root";
$pass = "";
db = "meubanco";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar: " . $e->getMessage());
}

$pedidos = $pdo->query("SELECT * FROM pedidos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
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
        <li>Entregue</li>
        <li>Enviado</li>
        <li>Cancelado</li>
        <li>Pendente</li>
        <li>Processamento</li>
      </ul>
    </div>
  </div>
</section>

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
        <th>Cliente</th>
        <th>Status</th>
        <th>Valor</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pedidos as $p): ?>
      <tr>
        <td><input type="checkbox"></td>
        <td><?= $p['produto'] ?></td>
        <td>#<?= $p['id'] ?></td>
        <td><?= $p['data_pedido'] ?></td>
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
</script>

</body>
</html>
