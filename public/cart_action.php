<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once __DIR__ . '/../conexao.php';

$userId = $_SESSION['user_id'] ?? null;
if (!$userId) {
  echo json_encode(['success' => false, 'message' => 'Usuário não logado']);
  exit;
}

$produtoId = (int)($_POST['produto_id'] ?? 0);

if ($produtoId <= 0) {
  echo json_encode(['success' => false, 'message' => 'Produto inválido']);
  exit;
}

$stmt = $pdo->prepare("
  SELECT id, quantity 
  FROM cart_items 
  WHERE user_id = ? AND product_id = ?
");
$stmt->execute([$userId, $produtoId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item) {
  $update = $pdo->prepare("
    UPDATE cart_items 
    SET quantity = quantity
    WHERE id = ?
  ");
  $update->execute([$item['id']]);
} else {
  $insert = $pdo->prepare("
    INSERT INTO cart_items (user_id, product_id, quantity)
    VALUES (?, ?, 1)
  ");
  $insert->execute([$userId, $produtoId]);
}

echo json_encode(['success' => true]);
