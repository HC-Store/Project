// ===============================
// DASHBOARD.JS CORRIGIDO (SPA + F5)
// ===============================

function initDashboard() {

    // Evita gráficos duplicados ao abrir o dashboard várias vezes
    if (window.pieChartInstance) window.pieChartInstance.destroy();
    if (window.lineChartInstance) window.lineChartInstance.destroy();

    // ---------------------------
    // GRÁFICO PIZZA
    // ---------------------------
    const elPie = document.getElementById('graficoPizza');
    if (elPie) {

        const ctxPie = elPie.getContext('2d');

        window.pieChartInstance = new Chart(ctxPie, {
            type: 'doughnut',
            data: {
                labels: pieLabels ?? ['Pedidos', 'Outros', 'Receita'],
                datasets: [{
                    data: pieData ?? [60, 20, 20],
                    borderWidth: 0,
                    backgroundColor: [
                        'rgba(255,99,132,0.85)',
                        'rgba(34,197,94,0.85)',
                        'rgba(59,130,246,0.85)'
                    ],
                    hoverOffset: 8
                }]
            },
            options: {
                cutout: '68%',
                plugins: {
                    legend: { display: true, position: 'bottom' },
                    tooltip: { enabled: true }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // ---------------------------
    // GRÁFICO DE LINHA
    // ---------------------------
    const elLine = document.getElementById('graficoLinha');
    if (elLine) {

        const ctxLine = elLine.getContext('2d');

        const gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59,130,246,0.28)');
        gradient.addColorStop(1, 'rgba(59,130,246,0.00)');

        window.lineChartInstance = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: lineLabels ?? ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                datasets: [{
                    label: 'Vendas',
                    data: lineData ?? [120,150,135,170,200,180,210,190,230,240,260,280],
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: 'rgba(59,130,246,0.95)',
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: 'rgba(59,130,246,1)'
                }]
            },
            options: {
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { grid: { display: false } },
                    y: { 
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        beginAtZero: true
                    }
                }
            }
        });
    }
}

// 🚀 Executa automaticamente se a página foi carregada via F5
if (document.getElementById("graficoPizza")) {
    initDashboard();
}
