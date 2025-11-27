<?php

$host = "mysql-1d434157-hcstore.f.aivencloud.com";
$port = 14949;
$db   = "defaultdb";
$user = "avnadmin";
$pass = ""; // coloque a senha da Aiven

// Caminho do certificado SSL baixado
$ssl_ca = __DIR__ . "/ca.pem";

try {
<<<<<<< HEAD
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
=======
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [
            PDO::MYSQL_ATTR_SSL_CA => $ssl_ca,
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        ]
    );

>>>>>>> 8a56efe924161c04beab51533f63f23563a8f67f
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
<<<<<<< HEAD
?>


=======
>>>>>>> 8a56efe924161c04beab51533f63f23563a8f67f
