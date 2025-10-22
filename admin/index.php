<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Painel Administrativo</title>

  <!-- CSS do painel -->
  <link rel="stylesheet" href="global.css">
</head>

<body>
<?php
  include(__DIR__ . '/../src/includes/sidebar.php');
  include(__DIR__ . '/../src/includes/header.php');
?>

  <main id="content">
    <?php include(__DIR__ . '/pages/dashboard.php'); ?>
  </main>

  <!-- Biblioteca externa para gráficos -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- JS principal do painel -->
  <script src="script.js" defer></script>
</body>
</html>
