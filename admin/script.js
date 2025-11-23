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

        // 🔥 CSS GLOBAL — sempre global.css
        if (currentCss) currentCss.remove();
        const newCss = document.createElement("link");
        newCss.rel = "stylesheet";
        newCss.href = "global.css"; // <-- AQUI ENTRA A PRIMEIRA OPÇÃO
        document.head.appendChild(newCss);
        currentCss = newCss;

        // Remove JS anterior e adiciona o JS da página se existir
        if (currentJs) currentJs.remove();
        const jsPath = `pages/${page}.js`; // opcional
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
  const btn = e.target.closest(".dropdown > .icon-btn");
  if (btn) {
    e.preventDefault();
    e.stopPropagation();

    const dropdown = btn.parentElement;
    const isOpen = dropdown.classList.contains("active");

    document.querySelectorAll(".dropdown.active").forEach(d => d.classList.remove("active"));

    if (!isOpen) dropdown.classList.add("active");
    return;
  }

  if (!e.target.closest(".dropdown")) {
    document.querySelectorAll(".dropdown.active").forEach(d => d.classList.remove("active"));
  }
});
