// --- Helpers para (re)inicializar com segurança ---
function initPizzaChart() {
  const canvas = document.getElementById('graficoPizza');
  if (!canvas) return false;
  const existing = Chart.getChart(canvas);
  if (existing) existing.destroy();

  const ctxPizza = canvas.getContext('2d');
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
  return true;
}

function initLinhaChart() {
  const canvas = document.getElementById('graficoLinha');
  if (!canvas) return false;
  const existing = Chart.getChart(canvas);
  if (existing) existing.destroy();

  const ctxLinha = canvas.getContext('2d');
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
  return true;
}

// Tenta inicializar os dois gráficos, retorna true se pelo menos um foi criado
function tryInitCharts() {
  const ok1 = initPizzaChart();
  const ok2 = initLinhaChart();
  return ok1 || ok2;
}

// 1) Tenta imediatamente (quando o dashboard veio como página inicial)
tryInitCharts();

// 2) Observa mudanças no <main id="content"> para re-inicializar ao voltar ao dashboard
(function observeContent() {
  const content = document.getElementById('content');
  if (!content) return;

  const reinit = () => {
    // Pequeno delay para garantir que o HTML já foi injetado
    requestAnimationFrame(() => {
      // se os canvases existem (estamos no dashboard), recria gráficos
      tryInitCharts();
    });
  };

  const observer = new MutationObserver((muts) => {
    // Se houve adição/troca de nós, tentamos recriar
    for (const m of muts) {
      if (m.type === 'childList' && (m.addedNodes?.length || m.removedNodes?.length)) {
        reinit();
        break;
      }
    }
  });

  observer.observe(content, { childList: true, subtree: true });
})();

