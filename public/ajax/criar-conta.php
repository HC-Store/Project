<?php
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once __DIR__ . '/../../conexao.php';

$resp = ['status' => 'error', 'errors' => []];

$nome  = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$senha = trim($_POST['password'] ?? '');

if ($nome === '') $resp['errors']['name'] = 'Informe seu nome.';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $resp['errors']['email'] = 'E-mail inválido.';
if ($senha === '' || strlen($senha) < 6) $resp['errors']['password'] = 'Senha muito curta.';

if ($resp['errors']) {
  echo json_encode($resp);
  exit;
}

$stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
  echo json_encode(['status'=>'error','errors'=>['email'=>'E-mail já cadastrado']]);
  exit;
}

$hash = password_hash($senha, PASSWORD_DEFAULT);

$insert = $pdo->prepare("
  INSERT INTO usuarios (nome, email, senha, tipo)
  VALUES (?, ?, ?, 'cliente')
");
$insert->execute([$nome, $email, $hash]);

$_SESSION['user_id']   = $pdo->lastInsertId();
$_SESSION['user_name'] = $nome;
$_SESSION['user_type'] = 'cliente';

echo json_encode(['status'=>'ok','name'=>$nome]);

?>
