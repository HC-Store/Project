<?php
$host = 'localhost';
$user = "root";
$password = '';
$dbname = "hcstore";

$conn = mysqli_connect($host, $user, $password, $dbname);


if (!$conn) {
    die("Erro na conexão: " . mysqli_connect_error());
} else {
    die("Sucesso na conexão");
}
?>