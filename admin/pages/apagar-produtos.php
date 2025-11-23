<?php
require_once __DIR__ . '/../../conexao.php';

header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input['ids']) || count($input['ids']) == 0) {
    echo json_encode(['success' => false, 'message' => 'Nenhum ID recebido']);
    exit;
}

$ids = $input['ids'];

try {
    // Deletar imagens
    $stmt = $pdo->prepare("SELECT caminho FROM produto_imagens WHERE produto_id = ?");
    $delImg = $pdo->prepare("DELETE FROM produto_imagens WHERE produto_id = ?");
    $delProd = $pdo->prepare("DELETE FROM produtos WHERE id = ?");

    foreach ($ids as $id) {

        // remover arquivos fisicos
        $stmt->execute([$id]);
        $imgs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($imgs as $img) {
            $path = __DIR__ . "/../../" . $img['caminho'];
            if (file_exists($path)) unlink($path);
        }

        // remover do banco
        $delImg->execute([$id]);
        $delProd->execute([$id]);
    }

    echo json_encode(['success' => true]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
