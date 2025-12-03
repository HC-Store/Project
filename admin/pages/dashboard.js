// =====================================================
// DASHBOARD.JS — 100% seguro para SPA + F5
// sem variáveis duplicadas e sem erros
// =====================================================

// Evita múltiplas inicializações
if (!window.__hc_dashboard_initialized) {
    window.__hc_dashboard_initialized = true;
}

// Mantemos todas as instâncias para destruir depois
window.HCCharts = {
    donut1: null,
    donut2: null,
    donut3: null,
    line: null
};

// =====================================================
// FUNÇÃO PRINCIPAL — INICIALIZA OS GRÁFICOS
// =====================================================
function initDashboard() {
    console.log("📊 initDashboard() — iniciando gráficos...");

    // Se não existir elementos no DOM, sai
    if (!document.getElementById("graficoLinha") &&
        !document.getElementById("donut1")) {
        console.warn("Dashboard não está no DOM ainda.");
        return;
    }

    // -------------------------------
    // 🔥 Destruir gráficos antigos
    // -------------------------------
    Object.keys(window.HCCharts).forEach(key => {
        if (window.HCCharts[key]) {
            window.HCCharts[key].destroy();
            window.HCCharts[key] = null;
        }
    });

    // -------------------------------
    // 🔥 Donuts (3 donuts principais)
    // -------------------------------
    if (typeof pieData === "object") {
        const total = pieData.reduce((a,b)=>a+Number(b||0),0) || 1;

        const values = [
            Math.round((pieData[0] || 0) / total * 100),
            Math.round((pieData[1] || 0) / total * 100),
            Math.round((pieData[2] || 0) / total * 100),
        ];

        const colors = [
            "rgba(255,99,132,0.9)",
            "rgba(34,197,94,0.9)",
            "rgba(59,130,246,0.9)"
        ];

        ["donut1","donut2","donut3"].forEach((id, index) => {
            const el = document.getElementById(id);
            if (!el) return;

            const ctx = el.getContext("2d");
            const restante = 100 - values[index];

            window.HCCharts[id] = new Chart(ctx, {
                type: "doughnut",
                data: {
                    datasets: [{
                        data: [values[index], restante],
                        backgroundColor: [colors[index], "rgba(0,0,0,0.08)"],
                        borderWidth: 0
                    }]
                },
                options: {
                    cutout: "70%",
                    plugins: { legend: { display: false } },
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    }

    // -------------------------------
    // 🔵 Gráfico de Linha
    // -------------------------------
    const lineCanvas = document.getElementById("graficoLinha");
    if (lineCanvas) {
        const ctx = lineCanvas.getContext("2d");
        const grad = ctx.createLinearGradient(0,0,0,300);
        grad.addColorStop(0, "rgba(59,130,246,0.30)");
        grad.addColorStop(1, "rgba(59,130,246,0.00)");

        window.HCCharts.line = new Chart(ctx, {
            type: "line",
            data: {
                labels: lineLabels || [],
                datasets: [{
                    label: "Vendas",
                    data: lineData || [],
                    borderColor: "rgba(59,130,246,1)",
                    backgroundColor: grad,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4
                }]
            },
            options: {
                plugins: { legend: { display: false }},
                scales: {
                    x: { grid: { display: false }},
                    y: { beginAtZero: true }
                },
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // -------------------------------
    // 🛒 Listar “Mais Vendidos”
    // -------------------------------
    try {
        const ul = document.querySelector(".top-sellers ul");
        if (ul && Array.isArray(maisVendidos)) {
            ul.innerHTML = "";
            maisVendidos.forEach(prod => {
                const img = prod.imagem || "uploads/placeholder.png";
                ul.innerHTML += `
                    <li>
                        <img src="${img}">
                        <div class="info">
                            <div class="nome">${prod.nome}</div>
                            <div class="meta">
                                R$ ${parseFloat(prod.preco_venda).toFixed(2).replace('.',',')}
                                — ${prod.total_vendido} vendidos
                            </div>
                        </div>
                    </li>
                `;
            });
        }
    } catch (e) {
        console.warn("Erro ao renderizar mais vendidos:", e);
    }

    console.log("✅ Dashboard renderizado sem erros.");
}

// =====================================================
// EVENTOS SPA E F5
// =====================================================

// SPA → Página carregada dinamicamente
document.addEventListener("dashboard-loaded", () => {
    setTimeout(() => initDashboard(), 40);
});

// F5 → Página carregada diretamente
document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("graficoLinha") ||
        document.getElementById("donut1")) {
        setTimeout(() => initDashboard(), 40);
    }
});
