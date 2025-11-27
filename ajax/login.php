<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

// Conexão correta
require_once __DIR__ . '/conexao.php';

$resp = ['status' => 'error', 'errors' => []];

// Dados vindos via POST
$login    = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

// Validação
if ($login === '')    $resp['errors']['login']    = 'Informe seu e-mail.';
if ($password === '') $resp['errors']['password'] = 'Informe sua senha.';

if ($resp['errors']) {
    echo json_encode($resp);
    exit;
}

// Verifica se é e-mail válido
$isEmail = filter_var($login, FILTER_VALIDATE_EMAIL);

if (!$isEmail) {
    $resp['errors']['login'] = "Digite um e-mail válido.";
    echo json_encode($resp);
    exit;
}

// Busca usuário (BANCO NOVO)
$stmt = $pdo->prepare("SELECT id, nome, email, senha, tipo FROM usuarios WHERE email = ? LIMIT 1");
$stmt->execute([$login]);

if ($stmt->rowCount() === 0) {
    $resp['errors']['login'] = "E-mail não encontrado.";
    echo json_encode($resp);
    exit;
}

$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Confere senha
if (!password_verify($password, $user['senha'])) {
    $resp['errors']['password'] = "Senha incorreta.";
    echo json_encode($resp);
    exit;
}

// Cria sessão atualizada
$_SESSION['user_id']   = $user['id'];
$_SESSION['user_name'] = $user['nome'];
$_SESSION['user_type'] = $user['tipo']; // admin | cliente

// Se for admin → resposta especial
if ($user['tipo'] === 'admin') {
    echo json_encode(['status' => 'admin']);
    exit;
}

// Usuário comum
echo json_encode([
    'status' => 'ok',
    'name'   => $user['nome']
]);
