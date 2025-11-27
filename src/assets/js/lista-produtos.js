document.addEventListener("DOMContentLoaded", () => {

  /* ============================================================================
     1. RESETAR FILTROS AO CLICAR FORA DO MENU LATERAL
  ============================================================================ */
  const filtroBox = document.querySelector(".menuLateral");
  const formFiltros = filtroBox?.querySelector("form");

  document.addEventListener("click", e => {
    if (!e.target.closest(".menuLateral")) {
      if (!formFiltros) return;

      // limpa radios
      formFiltros.querySelectorAll("input[type='radio']").forEach(r => r.checked = false);

      // reseta range
      const range = formFiltros.querySelector("input[type='range']");
      if (range) range.value = 2000;

      // recarrega página sem filtros
      window.location.href = window.location.pathname;
    }
  });

  /* ============================================================================
     2. LABEL DO RANGE (Atualizar em tempo real)
  ============================================================================ */
  const range = document.querySelector('input[name="price"]');
  const label = document.querySelector('.preco-label');
  const fmt = v => Number(v).toLocaleString('pt-BR',{minimumFractionDigits:2});

  if (range && label) {
    label.textContent = `Até R$ ${fmt(range.value)}`;
    range.addEventListener('input', () => {
      label.textContent = `Até R$ ${fmt(range.value)}`;
    });
  }

  /* ============================================================================
     3. BREADCRUMB AUTOMÁTICO Categoria > Subcategoria
  ============================================================================ */
 /* ====================== BREADCRUMB AUTOMÁTICO ====================== */

const categoriasNomes = {
  'acessorios': 'Acessórios',
  'calcados': 'Calçados',
  'perfumes': 'Perfumes',
  'roupas': 'Roupas',
  'casual': 'Moda Casual',
  'intima': 'Moda Íntima',
  'ofertas': 'Ofertas'
};

const subNomes = {
  // Acessórios
  'colar': 'Colar',
  'oculos': 'Óculos',
  'carteira': 'Carteira',
  'bag': 'Bag',
  'corrente': 'Corrente',
  'bone': 'Boné',
  'pulseira': 'Pulseira',
  'relogio': 'Relógio',
  'cinto': 'Cinto',

  // Calçados
  'tenis': 'Tênis',
  'sapatenis': 'Sapatênis',
  'chinelo': 'Chinelo',
  'bota': 'Bota',
  'sandalia': 'Sandália',

  // Perfumes
  'importados': 'Importados',
  'amadeirados': 'Amadeirados',
  'doces': 'Doces',
  'frescos': 'Frescos',

  // Roupas
  'camisetas': 'Camisetas',
  'moletom': 'Moletom',
  'calcas': 'Calças',
  'shorts': 'Shorts',
  'conjuntos': 'Conjuntos',

  // Moda Casual
  'camisas': 'Camisas',
  'polos': 'Polos',
  'bermudas': 'Bermudas',

  // Moda Íntima
  'cuecas': 'Cuecas',
  'meias': 'Meias',
  'pijamas': 'Pijamas',

  // Ofertas
  'promocoes': 'Promoções',
  'descontos': 'Descontos',
  'outlet': 'Outlet'
};

const params = new URLSearchParams(window.location.search);
const cat = params.get("category");
const sub = params.get("sub");

if (cat && categoriasNomes[cat]) {
  const bc = document.createElement("p");
  bc.className = "breadcrumb";

  let texto = categoriasNomes[cat];

  if (sub && subNomes[sub]) {
    texto += " > " + subNomes[sub];
  }

  bc.textContent = texto;

  const main = document.querySelector("main");
  if (main) main.prepend(bc);
}
});


