document.addEventListener("DOMContentLoaded", () => {
  // ======== FECHAR TODOS OS DROPDOWNS ========
  function fecharTodosDropdowns() {
    document.querySelectorAll(".dropdown-panel, .dropdown-mini, .popup, .categorias").forEach(el => el.style.display = "none");
  }

  // ======== ELEMENTOS ========
  const favIcon = document.getElementById("fav-icon");
  const bagIcon = document.getElementById("bag-icon");
  const userIcon = document.getElementById("user-icon");
  const favDropdown = document.getElementById("fav-dropdown");
  const bagDropdown = document.getElementById("bag-dropdown");
  const userDropdown = document.getElementById("user-dropdown");
  const popupLogin = document.getElementById("popup-login");
  const popupCriar = document.getElementById("popup-criar");
  const btnVoltar = document.getElementById("btn-voltar");

  // ======== LOCALSTORAGE ========
  let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
  let sacola = JSON.parse(localStorage.getItem("sacola")) || [];

  // ======== FUNÇÕES AUXILIARES ========
  const openFlex = el => { if (el) el.style.display = "flex"; };
  const hide = el => { if (el) el.style.display = "none"; };
  const isVisible = el => el && getComputedStyle(el).display !== "none";

  // ======== ATUALIZAR FAVORITOS ========
  function atualizarFavoritos() {
    const box = favDropdown.querySelector(".conteudo-fav");
    if (!box) return;
    box.innerHTML = favoritos.length
      ? favoritos.map((p, i) => `
        <div class="produto-exemplo">
          <img src="${p.img}" alt="${p.nome}">
          <div class="produto-info">
            <strong>${p.nome}</strong><span>${p.preco}</span>
          </div>
          <button class="remover-fav" data-i="${i}">✖</button>
        </div>`).join("")
      : "<p>Sem favoritos ainda.</p>";

    box.querySelectorAll(".remover-fav").forEach(btn => {
      btn.addEventListener("click", e => {
        e.stopPropagation();
        favoritos.splice(btn.dataset.i, 1);
        localStorage.setItem("favoritos", JSON.stringify(favoritos));
        atualizarFavoritos();
      });
    });
  }

  // ======== ATUALIZAR SACOLA ========
  function atualizarSacola() {
    const box = bagDropdown.querySelector(".conteudo-fav");
    const titulo = bagDropdown.querySelector("h3");
    titulo.textContent = `MINHA SACOLA (${sacola.length})`;
    box.innerHTML = sacola.length
      ? sacola.map((p, i) => `
        <div class="produto-exemplo">
          <img src="${p.img}" alt="${p.nome}">
          <div class="produto-info"><strong>${p.nome}</strong><span>${p.preco}</span></div>
          <button class="remover-sacola" data-i="${i}">✖</button>
        </div>`).join('')
      : "<p>Sua sacola está vazia.</p>";

    box.querySelectorAll(".remover-sacola").forEach(btn => {
      btn.addEventListener("click", e => {
        e.stopPropagation();
        sacola.splice(btn.dataset.i, 1);
        localStorage.setItem("sacola", JSON.stringify(sacola));
        atualizarSacola();
      });
    });
  }

  // ======== BOTÕES FAVORITAR E COMPRAR ========
  document.querySelectorAll(".product-card .fav").forEach(btn => {
    btn.addEventListener("click", e => {
      e.stopPropagation();
      btn.classList.toggle("active");
      const card = btn.closest(".product-card");
      const nome = card.querySelector(".title").textContent.trim();
      const preco = card.querySelector(".price").textContent.trim();
      const img = card.querySelector("img").src;

      if (btn.classList.contains("active")) {
        if (!favoritos.some(p => p.nome === nome)) favoritos.push({ nome, preco, img });
      } else {
        favoritos = favoritos.filter(p => p.nome !== nome);
      }
      localStorage.setItem("favoritos", JSON.stringify(favoritos));
      atualizarFavoritos();
    });
  });

  document.querySelectorAll(".product-card .btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const card = btn.closest(".product-card");
      const nome = card.querySelector(".title").textContent.trim();
      const preco = card.querySelector(".price").textContent.trim();
      const img = card.querySelector("img").src;
      sacola.push({ nome, preco, img });
      localStorage.setItem("sacola", JSON.stringify(sacola));
      atualizarSacola();
      openFlex(bagDropdown);
    });
  });

  // ======== DROPDOWN TOGGLE ========
  const toggleDropdown = (btn, dropdown) => {
    btn.addEventListener("click", e => {
      e.stopPropagation();
      const visible = isVisible(dropdown);
      fecharTodosDropdowns();
      if (!visible) openFlex(dropdown);
    });
  };

  if (favIcon && favDropdown) toggleDropdown(favIcon, favDropdown);
  if (bagIcon && bagDropdown) toggleDropdown(bagIcon, bagDropdown);

  if (userIcon && userDropdown) {
    userIcon.addEventListener("click", e => {
      e.stopPropagation();
      const visible = isVisible(userDropdown);
      fecharTodosDropdowns();
      userDropdown.style.display = visible ? "none" : "block";
    });
  }

  // ======== LOGIN POPUPS ========
  const btnEntrar = document.getElementById("btn-entrar");
  const btnCriar = document.getElementById("btn-criar");
  const linkCriar = document.getElementById("link-criar");
  const linkLogin = document.getElementById("link-login");

  btnEntrar?.addEventListener("click", () => { userDropdown.style.display = "none"; popupLogin.style.display = "flex"; });
  btnCriar?.addEventListener("click", () => { userDropdown.style.display = "none"; popupCriar.style.display = "flex"; });
  linkCriar?.addEventListener("click", e => { e.preventDefault(); popupLogin.style.display = "none"; popupCriar.style.display = "flex"; });
  linkLogin?.addEventListener("click", e => { e.preventDefault(); popupCriar.style.display = "none"; popupLogin.style.display = "flex"; });

  document.addEventListener("click", e => {
    if (!e.target.closest(".user-menu, .popup, .categorias, .dropdown-panel")) fecharTodosDropdowns();
  });

  document.addEventListener("keydown", e => { if (e.key === "Escape") fecharTodosDropdowns(); });

  // ======== FILTRO DE PREÇO (slider dinâmico) ========
  const range = document.querySelector('input[name="preco"]');
  const label = range?.nextElementSibling;
  if (range && label) {
    range.addEventListener("input", () => {
      label.textContent = `Até R$ ${range.value},00`;
    });
  }

  atualizarFavoritos();
  atualizarSacola();
});
