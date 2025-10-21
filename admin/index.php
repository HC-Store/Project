<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>

  <!-- CSS global -->
  <link rel="stylesheet" href="src/assets/css/global.css">
</head>

<body>
  <?php
    // Caminho corrigido (inclui SRC e ASSETS)
    include(__DIR__ . "/src/assets/includes/sidebar.php");
    include(__DIR__ . "/src/assets/includes/header.php");
  ?>

  <main id="content">
    <?php include(__DIR__ . "/src/assets/pages/dashboard.php"); ?>
  </main>

  <!-- Chart.js (gráficos) -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Script global -->
  <script src="src/assets/js/script.js"></script>
</body>
</html>