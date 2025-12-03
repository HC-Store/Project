// ===============================================
// SPA — TROCA DE PÁGINAS
// ===============================================

document.addEventListener("DOMContentLoaded", () => {

  const main = document.getElementById("content");
  const pageButtons = document.querySelectorAll(".menu-link[data-page]");
  let currentCss = null;
  let currentJs = null;

  // Carregar páginas internas
  async function loadPage(page) {
    try {
      console.log(`🔄 Carregando página: ${page}`);

      // 1. Carregar HTML
      const response = await fetch(`pages/${page}.php`);
      if (!response.ok) throw new Error(`Erro ao carregar ${page}.php`);
      main.innerHTML = await response.text();

      // 2. CSS da página
      if (currentCss) currentCss.remove();
      const newCss = document.createElement("link");
      newCss.rel = "stylesheet";
      newCss.href = `pages/${page}.css?cache=${Date.now()}`;
      document.head.appendChild(newCss);
      currentCss = newCss;

      // 3. JS da página
      if (currentJs) currentJs.remove();
      const jsPath = `pages/${page}.js`;
      const newJs = document.createElement("script");
      newJs.src = jsPath;
      newJs.defer = true;

      newJs.onload = () => {
        console.log(`📌 JS carregado: ${jsPath}`);

        if (page === "dashboard") {
          document.dispatchEvent(new Event("dashboard-loaded"));
        }
      };

      document.body.appendChild(newJs);
      currentJs = newJs;

    } catch (error) {
      console.error(error);
      main.innerHTML = `<p style="color:red;">${error.message}</p>`;
    }
  }

  // Clique nos botões do menu
  pageButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      const page = btn.getAttribute("data-page");
      loadPage(page);
    });
  });

  // Carrega dashboard apenas uma vez
  if (!window._dashboard_loaded_once) {
    window._dashboard_loaded_once = true;
    loadPage("dashboard");
  }

  // ===============================================
  // DROPDOWNS (lupa, sino, admin)
  // ===============================================
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".dropdown > .icon-btn");

    if (btn) {
      e.preventDefault();
      e.stopPropagation();

      const dropdown = btn.parentElement;
      const isOpen = dropdown.classList.contains("active");

      document.querySelectorAll(".dropdown.active")
        .forEach(d => d.classList.remove("active"));

      if (!isOpen) dropdown.classList.add("active");
      return;
    }

    if (!e.target.closest(".dropdown")) {
      document.querySelectorAll(".dropdown.active")
        .forEach(d => d.classList.remove("active"));
    }
  });

});  // 🔥 FECHA DOMContentLoaded CORRETAMENTE
