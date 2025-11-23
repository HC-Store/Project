<?php
session_start();

// tenta localizar conexao.php
$possible = [
  __DIR__ . '/../../src/conexao.php',
  __DIR__ . '/../../conexao.php',
  __DIR__ . '/../../../src/conexao.php',
  __DIR__ . '/../src/conexao.php',
  __DIR__ . '/src/conexao.php',
  __DIR__ . '/conexao.php'
];

$pdo = null;
foreach ($possible as $p) {
  if (file_exists($p)) {
    require_once $p;
    break;
  }
}

/* ============================================================
   ENDPOINT AJAX — SEMPRE NO TOPO E SEM HTML ANTES
============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header("Content-Type: application/json; charset=utf-8");

    /* ==============================================
       1) Criar produto
    ============================================== */
    if ($_POST['action'] === 'create_product') {

        $nome = trim($_POST['nome'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $categoria = trim($_POST['categoria'] ?? '');
        $marca = trim($_POST['marca'] ?? '');
        $numero_estoque = trim($_POST['numero_estoque'] ?? '');
        $quantidade = (int)($_POST['quantidade'] ?? 0);

        // normalizar moedas
        $preco_normal = trim($_POST['preco_normal'] ?? '0');
        $preco_venda  = trim($_POST['preco_venda'] ?? '0');

        $preco_normal = str_replace(['R$', '.', ','], ['', '', '.'], $preco_normal);
        $preco_venda  = str_replace(['R$', '.', ','], ['', '', '.'], $preco_venda);

        $preco_normal = (float)$preco_normal;
        $preco_venda  = (float)$preco_venda;

        if (!$pdo) {
            echo json_encode(['success' => false, 'message' => 'Conexão não encontrada']);
            exit;
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO produtos
               (nome, descricao, categoria, marca, numero_estoque, quantidade, preco_normal, preco_venda)
               VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([
                $nome, $descricao, $categoria, $marca,
                $numero_estoque, $quantidade,
                $preco_normal, $preco_venda
            ]);

            echo json_encode(['success' => true, 'produto_id' => $pdo->lastInsertId()]);
            exit;

        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit;
        }
    }

    /* ==============================================
       2) Upload de Imagem
    ============================================== */
    if ($_POST['action'] === 'upload_image') {

        if (!$pdo) {
            echo json_encode(['success' => false, 'message' => 'Conexão não encontrada']);
            exit;
        }

        $produto_id = (int)($_POST['produto_id'] ?? 0);
        if ($produto_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit;
        }

        if (!isset($_FILES['image'])) {
            echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado']);
            exit;
        }

        $file = $_FILES['image'];
        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        $mime = mime_content_type($file['tmp_name']);

        if (!in_array($mime, $allowed)) {
            echo json_encode(['success' => false, 'message' => 'Formato não permitido']);
            exit;
        }

        if ($file['size'] > (5 * 1024 * 1024)) {
            echo json_encode(['success' => false, 'message' => 'Máximo 5MB']);
            exit;
        }

        $dir = __DIR__ . "/uploads/products/";
        if (!is_dir($dir)) mkdir($dir, 0777, true);

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $safeName = time() . "_" . bin2hex(random_bytes(5)) . "." . $ext;

        $dest = $dir . $safeName;

        if (!move_uploaded_file($file['tmp_name'], $dest)) {
            echo json_encode(['success' => false, 'message' => 'Falha ao salvar imagem']);
            exit;
        }

        $caminho = "uploads/products/" . $safeName;

        $stmt = $pdo->prepare("SELECT COALESCE(MAX(ordenacao),0)+1 FROM produto_imagens WHERE produto_id = ?");
        $stmt->execute([$produto_id]);
        $ord = $stmt->fetchColumn();

        $stmt = $pdo->prepare("INSERT INTO produto_imagens (produto_id, caminho, ordenacao) VALUES (?, ?, ?)");
        $stmt->execute([$produto_id, $caminho, $ord]);

        echo json_encode(['success' => true, 'caminho' => $caminho]);
        exit;
    }

    echo json_encode(['success' => false, 'message' => 'Ação inválida']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Adicionar Produto</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
/* ====== RESET ====== */
*{margin:0;padding:0;box-sizing:border-box;font-family:"Rubik",sans-serif;}
body{background:#fff;padding:28px;color:#222;}

/* ====== TÍTULO ====== */
.page-title h1{font-size:26px;font-weight:700;}
.page-title p{font-size:14px;color:#666;margin-top:6px;text-decoration:underline;}

/* ====== GRID PRINCIPAL ====== */
.form-adicionar{
  display:grid;
  grid-template-columns:1.25fr 1fr;
  gap:34px;
  max-width:1100px;
  margin:20px auto;
}

/* ====== INPUTS ====== */
.left-col label{font-size:14px;font-weight:600;margin-top:14px;display:block;}
.left-col input, .left-col textarea{
  width:100%;
  padding:12px 14px;
  border:1px solid #ccc;
  border-radius:8px;
  font-size:14px;
  margin-top:6px;
}
.left-col textarea{min-height:120px;resize:vertical;}

/* ====== PREVIEW ====== */
.preview-box{padding:10px;background:#fff;border-radius:10px;}
.preview-image{
  width:100%;height:220px;border-radius:10px;background:#f0f0f0;
  display:flex;align-items:center;justify-content:center;
}
.preview-image img{width:100%;height:100%;object-fit:cover;border-radius:10px;}

/* ====== UPLOAD ====== */
.upload-area{
  border:2px dashed #bbb;
  padding:25px;margin-top:12px;border-radius:10px;text-align:center;
}
.upload-area p{color:#666;margin-top:10px;font-size:14px;}

.upload-list{margin-top:20px;display:flex;flex-direction:column;gap:12px;}

.upload-item{
  background:#f6f6f6;padding:10px;border-radius:10px;
  display:flex;align-items:center;gap:12px;
}
.upload-thumb{width:60px;height:48px;border-radius:6px;object-fit:cover;}
.progress{width:100%;height:6px;background:#ddd;border-radius:6px;margin-top:6px;}
.progress-bar{height:100%;width:0%;background:#3b82f6;border-radius:6px;}
.upload-check{opacity:0;transition:.3s;}

/* ====== BOTÕES ====== */
.botoes-edit{
  grid-column:1/-1;
  display:flex;justify-content:center;gap:20px;margin-top:20px;
}
.btn-add,.btn-cancel{
  width:200px;height:48px;border:none;border-radius:10px;
  font-weight:700;font-size:15px;color:#fff;cursor:pointer;transition:.3s;
}
.btn-add{background:#111;}
.btn-add:hover{background:#d4af37;box-shadow:0 0 12px #d4af37;}
.btn-cancel{background:#000;}
.btn-cancel:hover{background:#8b0000;box-shadow:0 0 12px #8b0000;}

.msg{text-align:center;color:green;margin-top:10px;}
</style>
</head>
<body>

<div class="page-title">
  <h1>Detalhes do Produto</h1>
  <p>Home &gt; Todos produtos &gt; Adicionar novo produto</p>
</div>

<div id="mensagem"></div>

<form class="form-adicionar" id="form-adicionar" enctype="multipart/form-data" novalidate>

  <!-- COLUNA ESQUERDA -->
  <div class="left-col">

    <label>Nome do Produto *</label>
    <input type="text" id="nome" required>

    <label>Descrição</label>
    <textarea id="descricao"></textarea>

    <div id="contador-desc" style="font-size:13px;color:#666;margin-top:6px;">0/500</div>

    <label>Categoria</label>
    <input type="text" id="categoria">

    <label>Marca</label>
    <input type="text" id="marca">

    <div style="display:flex; gap:12px; margin-top:10px;">
      <div style="flex:1;">
        <label>Número Estoque</label>
        <input type="text" id="numero_estoque">
      </div>

      <div style="width:140px;">
        <label>Quantidade</label>
        <input type="number" id="quantidade" value="0" min="0">
      </div>
    </div>

    <div style="display:flex; gap:12px; margin-top:12px;">
      <div style="flex:1;">
        <label>Preço Normal</label>
        <input type="text" id="preco_normal" placeholder="R$0,00">
      </div>

      <div style="width:160px;">
        <label>Preço de Venda *</label>
        <input type="text" id="preco_venda" placeholder="R$0,00" required>
      </div>
    </div>

    <input type="file" id="file-multiple" accept="image/*" multiple hidden>

  </div>

  <!-- COLUNA DIREITA -->
  <div class="preview-box">
    <div class="preview-image">
      <img id="main-image" src="https://placehold.co/500x300?text=Preview">
    </div>

    <div class="gallery-title">Galeria de Produtos</div>

    <div class="upload-area" id="upload-area">
      <p>
        Arraste imagens aqui ou 
        <button type="button" id="select-btn" style="background:none;border:none;color:#3b82f6;font-weight:700;cursor:pointer;">selecionar</button><br>
        JPG, PNG, WEBP até 5MB
      </p>
    </div>

    <div class="upload-list" id="upload-list"></div>
  </div>

  <!-- BOTÕES -->
  <div class="botoes-edit">
    <button type="button" id="btn-salvar" class="btn-add">ADICIONAR</button>
    <button type="button" id="btn-cancelar" class="btn-cancel">CANCELAR</button>
  </div>

</form>

<!-- APENAS UM SCRIPT -->


</body>
</html>
