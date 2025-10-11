// === GRÁFICO PIZZA ===
const ctxPizza = document.getElementById('graficoPizza');
new Chart(ctxPizza, {
  type: 'doughnut',
  data: {
    labels: ['Pedidos', 'Porcentagem', 'Receita'],
    datasets: [{
      data: [81, 22, 82],
      backgroundColor: ['#DAA520', '#28a745', '#007bff'],
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: { legend: { position: 'bottom' } }
  }
});

// === GRÁFICO LINHA ===
const ctxLinha = document.getElementById('graficoLinha');
new Chart(ctxLinha, {
  type: 'line',
  data: {
    labels: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
    datasets: [{
      label: 'Vendas',
      data: [650, 820, 780, 560, 590, 620, 700, 850, 900, 1000, 1100, 1200],
      borderColor: '#007bff',
      backgroundColor: 'rgba(0,123,255,0.1)',
      fill: true,
      tension: 0.3
    }]
  },
  options: {
    responsive: true,
    scales: { y: { beginAtZero: true } }
  }
});

