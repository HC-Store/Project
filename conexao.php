<?php
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "hcstore";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Não coloque echo aqui!
} catch (PDOException $erro) {
    // Aqui você pode manter o erro caso queira debug
    die("Erro na conexão: " . $erro->getMessage());
}
?>
