<?php
try {
    // Configurações da conexão com o banco
    $host = "localhost";
    $dbname = "hc_store"; // ✅ nome correto do seu banco de dados
    $usuario = "root";   // padrão do XAMPP
    $senha = "";         // padrão é vazio no XAMPP

    // Criação da conexão PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
