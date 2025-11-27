<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

// Conexão correta
require_once __DIR__ . '/conexao.php';

$resp = ['status' => 'error', 'errors' => []];

// Campos vindos do formulário
$nome     = trim($_POST['name']     ?? '');
$email    = trim($_POST['email']    ?? '');
$telefone = trim($_POST['phone']    ?? '');
$senha    = trim($_POST['password'] ?? '');

// ======= VALIDAÇÕES =======
if ($nome === '') {
    $resp['errors']['name'] = 'Informe seu nome.';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $resp['errors']['email'] = 'E-mail inválido.';
}

if ($senha === '' || strlen($senha) < 6) {
    $resp['errors']['password'] = 'A senha deve ter no mínimo 6 caracteres.';
}

if ($resp['errors']) {
    echo json_encode($resp);
    exit;
}

// Verifica e-mail duplicado
$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ? LIMIT 1");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    $resp['errors']['email'] = 'E-mail já cadastrado.';
    echo json_encode($resp);
    exit;
}

// Tipo fixo para qualquer usuário criado no site
$tipo = 'cliente';

// Gera hash da senha
$hash = password_hash($senha, PASSWORD_DEFAULT);

// ======= INSERIR USUÁRIO =======
$insert = $pdo->prepare("
    INSERT INTO usuarios (nome, email, senha, tipo)
    VALUES (?, ?, ?, ?)
");

$ok = $insert->execute([$nome, $email, $hash, $tipo]);

if (!$ok) {
    echo json_encode([
        'status' => 'error',
        'errors' => ['general' => 'Erro ao criar conta.']
    ]);
    exit;
}

// ID do usuário criado
$userId = $pdo->lastInsertId();

// Criar sessão automática
$_SESSION['user_id']   = $userId;
$_SESSION['user_name'] = $nome;
$_SESSION['user_type'] = $tipo;

// Retorno final
echo json_encode([
    'status' => 'ok',
    'name'   => $nome
]);
