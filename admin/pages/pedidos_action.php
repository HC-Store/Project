<?php
require_once __DIR__ . '/../../conexao.php';

header("Content-Type: application/json");

if ($_POST['action'] === 'alterar_status') {

    $id = intval($_POST['id']);
    $status = trim($_POST['status']);

    if (!$id || !$status) {
        echo json_encode(["success" => false, "message" => "Dados inválidos"]);
        exit;
    }

    $stmt = $pdo->prepare("UPDATE pedidos SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);

    echo json_encode(["success" => true]);
    exit;
}
