<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo</title>

  <!-- CSS global -->
  <link rel="stylesheet" href="global.css">
</head>

<body>

<?php
  include(__DIR__ . '/../src/includes/sidebar.php');
  include(__DIR__ . '/../src/includes/header.php');
?>

  <!-- SPA injeta páginas aqui -->
  <main id="content"></main>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- SPA principal -->
  <script src="script.js" defer></script>

</body>
</html>
