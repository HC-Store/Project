document.addEventListener("DOMContentLoaded", () => {
  const main = document.getElementById("content");

  // Botões que têm data-page = troca de páginas
  const pageButtons = document.querySelectorAll(".menu-link[data-page]");

  // Botão e submenu de categorias
  const categoriasBtn = document.querySelector(".categorias-btn");
  const categoriasLista = document.getElementById("categorias-lista");

  // Controladores de CSS e JS dinâmicos
  let currentCss = null;
  let currentJs = null;

  // ✅ 1. Lógica do submenu "Categorias"
  if (categoriasBtn && categoriasLista) {
    categoriasBtn.addEventListener("click", () => {
      categoriasLista.classList.toggle("open");
    });
  }

  // ✅ 2. Lógica de troca de páginas dinâmicas
  pageButtons.forEach(btn => {
    btn.addEventListener("click", async () => {
      const page = btn.getAttribute("data-page");

      try {
        // Carrega o conteúdo da página PHP
        const response = await fetch(`pages/${page}.php`);
        if (!response.ok) throw new Error(`Erro ao carregar ${page}.php`);
        const html = await response.text();
        main.innerHTML = html;

        // Remove CSS anterior e adiciona o novo
        if (currentCss) currentCss.remove();
        const cssPath = `../src/assets/css/${page}.css`;
        const newCss = document.createElement("link");
        newCss.rel = "stylesheet";
        newCss.href = cssPath;
        document.head.appendChild(newCss);
        currentCss = newCss;

        // Remove JS anterior e adiciona o novo
        if (currentJs) currentJs.remove();
        const jsPath = `../src/assets/js/${page}.js`;
        const newJs = document.createElement("script");
        newJs.src = jsPath;
        newJs.defer = true;
        document.body.appendChild(newJs);
        currentJs = newJs;

        console.log(`✅ Página carregada: ${page}.php`);
      } catch (error) {
        console.error("Erro:", error);
        main.innerHTML = `<p style="color:red;">${error.message}</p>`;
      }
    });
  });
});


// Toggle do menu de categorias
document.addEventListener("DOMContentLoaded", () => {
  const categoriasBtn = document.querySelector(".categorias-btn");
  const submenu = document.getElementById("categorias-lista");

  if (categoriasBtn) {
    categoriasBtn.addEventListener("click", () => {
      submenu.classList.toggle("open");
      categoriasBtn.classList.toggle("active");
    });
  }
});
// === DROPDOWNS (lupa, sino, admin) – delegação de eventos ===
document.addEventListener("click", (e) => {
  // Clique no botão (ícone) dentro de um .dropdown
  const btn = e.target.closest(".dropdown > .icon-btn");
  if (btn) {
    e.preventDefault();
    e.stopPropagation();

    const dropdown = btn.parentElement; // .dropdown
    const isOpen = dropdown.classList.contains("active");

    // Fecha todos antes de abrir o atual
    document.querySelectorAll(".dropdown.active").forEach(d => d.classList.remove("active"));

    // Abre/fecha o atual
    if (!isOpen) dropdown.classList.add("active");
    return; // evita cair no fechamento global
  }

  // Se clicou fora de qualquer dropdown, fecha todos
  if (!e.target.closest(".dropdown")) {
    document.querySelectorAll(".dropdown.active").forEach(d => d.classList.remove("active"));
  }
});
