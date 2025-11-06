<?php
$host = 'localhost';
$dbname = 'hcstore';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $password); // sem dbname
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexão bem-sucedida (sem banco)";
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
