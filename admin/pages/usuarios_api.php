<?php
require_once __DIR__ . "/../../conexao.php";

header("Content-Type: application/json");

// Excluir 1 usuário
if ($_POST['action'] === "delete_one") {
    $id = intval($_POST['id']);

    $pdo->prepare("DELETE FROM usuarios WHERE id = ?")->execute([$id]);

    echo json_encode(["success" => true]);
    exit;
}

// Excluir vários
if ($_POST['action'] === "delete_many") {
    $ids = json_decode($_POST['ids'], true);

    if (!is_array($ids)) {
        echo json_encode(["success" => false, "message" => "IDs inválidos"]);
        exit;
    }

    $in = implode(",", array_fill(0, count($ids), "?"));
    $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id IN ($in)");
    $stmt->execute($ids);

    echo json_encode(["success" => true]);
    exit;
}
