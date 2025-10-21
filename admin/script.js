// Aguarda o DOM estar carregado antes de iniciar
document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".menu-link"); // classe dos botões do menu lateral
  const content = document.getElementById("content"); // onde o conteúdo das páginas será inserido

  // Percorre todos os botões e adiciona o evento de clique
  links.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault(); // impede o recarregamento total da página

      const page = link.getAttribute("data-page"); // lê o nome da página a ser carregada
      const url = `src/assets/pages/${page}.php`; // caminho correto para as páginas

      // Requisição AJAX para carregar o conteúdo da página
      fetch(url)
        .then(res => {
          if (!res.ok) throw new Error("Página não encontrada");
          return res.text();
        })
        .then(html => {
          content.innerHTML = html; // insere o conteúdo da página no main
          loadPageCSS(page);        // carrega o CSS correspondente
          loadPageJS(page);         // carrega o JS correspondente
        })
        .catch(err => {
          content.innerHTML = `<p style="color:red; font-weight:600; text-align:center;">Erro: ${err.message}</p>`;
        });
    });
  });
});

// === Função para carregar o CSS da página dinamicamente ===
function loadPageCSS(page) {
  const existingLink = document.getElementById("page-style");
  if (existingLink) existingLink.remove();

  const link = document.createElement("link");
  link.rel = "stylesheet";
  link.href = `src/assets/css/${page}.css`; // caminho relativo
  link.id = "page-style";
  document.head.appendChild(link);
}

// === Função para carregar o JS da página dinamicamente ===
function loadPageJS(page) {
  const existingScript = document.getElementById("page-script");
  if (existingScript) existingScript.remove();

  const script = document.createElement("script");
  script.src = `src/assets/js/${page}.js`; // caminho relativo
  script.id = "page-script";
  document.body.appendChild(script);
}
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
