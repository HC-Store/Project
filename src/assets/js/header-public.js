document.addEventListener("DOMContentLoaded", () => {

  /* ============================================================
        FUNÇÕES GENÉRICAS
  ============================================================ */
  const openFlex  = el => el && (el.style.display = "flex");
  const openBlock = el => el && (el.style.display = "block");
  const hide      = el => el && (el.style.display = "none");
  const isVisible = el => el && getComputedStyle(el).display !== "none";

  function fecharTodos() {
    document.querySelectorAll(".dropdown-panel, .dropdown-mini, .popup, .categorias")
      .forEach(el => hide(el));
  }

  /* ============================================================
        ELEMENTOS DO HEADER
  ============================================================ */
  const favIcon      = document.getElementById("fav-icon");
  const bagIcon      = document.getElementById("bag-icon");
  const userIcon     = document.getElementById("user-icon");

  const favDropdown  = document.getElementById("fav-dropdown");
  const bagDropdown  = document.getElementById("bag-dropdown");
  const userDropdown = document.getElementById("user-dropdown");

  const popupLogin   = document.getElementById("popup-login");
  const popupCriar   = document.getElementById("popup-criar");

  const btnEntrar    = document.querySelector(".dropdown-mini button:nth-child(1)");
  const btnCriar     = document.querySelector(".dropdown-mini button:nth-child(2)");

  const linkCriar    = document.getElementById("link-criar");
  const linkLogin    = document.getElementById("link-login");

  const btnVoltar        = document.getElementById("btn-voltar");
  const btnPagamento     = document.getElementById("btn-pagamento");
  const btnContinuarFav  = document.getElementById("btn-continuar-fav");

  const menuLinks = document.querySelectorAll(".menu a");

  /* ============================================================
        LOCALSTORAGE – FAVORITOS / SACOLA
  ============================================================ */
  let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
  let sacola    = JSON.parse(localStorage.getItem("sacola")) || [];

  const salvarFavoritos = () =>
    localStorage.setItem("favoritos", JSON.stringify(favoritos));

  const salvarSacola = () =>
    localStorage.setItem("sacola", JSON.stringify(sacola));

  /* ============================================================
        RENDER FAVORITOS
  ============================================================ */
  function atualizarFavoritos() {
    const content = document.getElementById("fav-content");
    if (!content) return;

    if (favoritos.length === 0) {
      content.innerHTML = `<p class="empty-msg">Sem favoritos ainda.</p>`;
      return;
    }

    content.innerHTML = favoritos
      .map(
        (p, i) => `
      <div class="dropdown-product">
        <img src="${p.img}" alt="${p.nome}">
        <div>
          <strong>${p.nome}</strong><br>
          <span>${p.preco}</span>
        </div>
        <button class="remover-fav" data-index="${i}">✖</button>
      </div>`
      )
      .join("");

    document.querySelectorAll(".remover-fav").forEach(btn => {
      btn.addEventListener("click", e => {
        e.stopPropagation();
        favoritos.splice(btn.dataset.index, 1);
        salvarFavoritos();
        atualizarFavoritos();
      });
    });
  }

  /* ============================================================
        RENDER SACOLA
  ============================================================ */
  function atualizarSacola() {
    const content = document.getElementById("bag-content");
    const title   = bagDropdown?.querySelector(".dropdown-title");

    if (!content || !title) return;

    title.textContent = `Minha sacola (${sacola.length})`;

    if (sacola.length === 0) {
      content.innerHTML = `<p class="empty-msg">Sua sacola está vazia</p>`;
      return;
    }

    content.innerHTML = sacola
      .map(
        (p, i) => `
      <div class="dropdown-product">
        <img src="${p.img}" alt="${p.nome}">
        <div>
          <strong>${p.nome}</strong><br>
          <span>${p.preco}</span>
        </div>
        <button class="remover-sacola" data-index="${i}">✖</button>
      </div>`
      )
      .join("");

    document.querySelectorAll(".remover-sacola").forEach(btn => {
      btn.addEventListener("click", e => {
        e.stopPropagation();
        sacola.splice(btn.dataset.index, 1);
        salvarSacola();
        atualizarSacola();
      });
    });
  }

  atualizarFavoritos();
  atualizarSacola();

  /* ============================================================
        BOTÕES DE FAVORITAR E SACOLA (EM QUALQUER PÁGINA)
  ============================================================ */
  document.querySelectorAll(".product-card .fav").forEach(btn => {
    btn.addEventListener("click", () => {
      btn.classList.toggle("active");

      const card  = btn.closest(".product-card");
      const nome  = card.querySelector(".title")?.textContent.trim();
      const preco = card.querySelector(".price")?.textContent.trim();
      const img   = card.querySelector("img")?.src;

      if (btn.classList.contains("active")) {
        favoritos.push({ nome, preco, img });
      } else {
        favoritos = favoritos.filter(p => p.nome !== nome);
      }

      salvarFavoritos();
      atualizarFavoritos();
    });
  });

  document.querySelectorAll(".product-card .btn").forEach(btn => {
    btn.addEventListener("click", () => {
      const card  = btn.closest(".product-card");
      const nome  = card.querySelector(".title")?.textContent.trim();
      const preco = card.querySelector(".price")?.textContent.trim();
      const img   = card.querySelector("img")?.src;

      sacola.push({ nome, preco, img });
      salvarSacola();
      atualizarSacola();

      fecharTodos();
      openFlex(bagDropdown);
    });
  });

  /* ============================================================
        DROPDOWNS
  ============================================================ */
  function toggleDropdown(btn, dropdown) {
    btn?.addEventListener("click", e => {
      e.stopPropagation();
      const aberto = isVisible(dropdown);
      fecharTodos();
      if (!aberto) openFlex(dropdown);
    });
  }

  toggleDropdown(favIcon, favDropdown);
  toggleDropdown(bagIcon, bagDropdown);

  userIcon?.addEventListener("click", e => {
    e.stopPropagation();
    const aberto = isVisible(userDropdown);
    fecharTodos();
    if (!aberto) openBlock(userDropdown);
  });

  /* ============================================================
        LOGIN / CRIAR CONTA
  ============================================================ */
  btnEntrar?.addEventListener("click", e => {
    e.stopPropagation();
    hide(userDropdown);
    openFlex(popupLogin);
  });

  btnCriar?.addEventListener("click", e => {
    e.stopPropagation();
    hide(userDropdown);
    openFlex(popupCriar);
  });

  linkCriar?.addEventListener("click", e => {
    e.preventDefault();
    hide(popupLogin);
    openFlex(popupCriar);
  });

  linkLogin?.addEventListener("click", e => {
    e.preventDefault();
    hide(popupCriar);
    openFlex(popupLogin);
  });

  // Botões de controle
  btnVoltar?.addEventListener("click", () => fecharTodos());
  btnContinuarFav?.addEventListener("click", () => fecharTodos());
  btnPagamento?.addEventListener("click", () => {
    window.location.href = "checkout.php";
  });

  /* ============================================================
        MENU PRINCIPAL → ABRIR SUBMENUS
  ============================================================ */
  menuLinks.forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      e.stopPropagation();

      const cat = link.dataset.cat;
      const target = document.getElementById(`cat-${cat}`);

      const aberto = isVisible(target);
      fecharTodos();
      if (!aberto) openBlock(target);
    });
  });

  /* ============================================================
        SUBCATEGORIAS → REDIRECIONAR PARA lista-produtos.php
  ============================================================ */
  document.querySelectorAll(".categorias-grid a").forEach(link => {
    link.addEventListener("click", e => {
      e.preventDefault();
      e.stopPropagation();

      const secao = link.closest(".categorias").id.replace("cat-", "");

      const sub = link.textContent.trim()
        .normalize("NFD").replace(/\p{Diacritic}/gu, "")
        .toLowerCase()
        .replace(/\s+/g, "-");

      let url = `lista-produtos.php?category=${secao}&sub=${sub}`;
      window.location.href = url;
    });
  });

  /* ============================================================
        FECHAR DROPDOWNS AO CLICAR FORA OU ESC
  ============================================================ */
  document.addEventListener("click", e => {
    if (!e.target.closest(".user-menu, .categorias, .popup, .dropdown-panel, .dropdown-mini")) {
      fecharTodos();
    }
  });

  document.addEventListener("keydown", e => {
    if (e.key === "Escape") fecharTodos();
  });

  /* ============================================================
        VALIDAÇÃO FORM LOGIN/CRIAR CONTA
  ============================================================ */
  function clearErrors(ctx) {
    ctx.querySelectorAll(".field-error").forEach(e => (e.textContent = ""));
  }

  function setError(ctx, field, msg) {
    const el = ctx.querySelector(`.field-error[data-err="${field}"]`);
    if (el) el.textContent = msg;
  }

  const validateEmail    = email => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  const validateCPF      = cpf   => /^\d{11}$/.test(cpf);
  const validatePassword = pw    => pw.length >= 6;

  /* LOGIN */
  const formLogin = document.getElementById("form-login");
  formLogin?.addEventListener("submit", e => {
    e.preventDefault();

    clearErrors(formLogin);
    const fd    = new FormData(formLogin);
    const login = fd.get("login")?.trim();
    const senha = fd.get("password")?.trim();

    if (!login) return setError(formLogin, "login", "Digite seu CPF ou E-mail");
    if (!senha) return setError(formLogin, "password", "Digite sua senha");

    if (login.includes("@") && !validateEmail(login))
      return setError(formLogin, "login", "E-mail inválido");

    if (!login.includes("@") && !validateCPF(login))
      return setError(formLogin, "login", "CPF inválido");

    if (!validatePassword(senha))
      return setError(formLogin, "password", "Mínimo 6 caracteres");

    fetch("ajax/login.php", { method: "POST", body: fd })
      .then(r => r.json())
      .then(data => {
        if (data.status === "admin")
          return (window.location.href = "admin/dashboard.php");

        if (data.status === "ok") {
          alert("Login realizado com sucesso!");
          hide(popupLogin);
          location.reload();
          return;
        }

        if (data.errors) {
          Object.entries(data.errors).forEach(([k, msg]) =>
            setError(formLogin, k, msg)
          );
        } else {
          setError(formLogin, "general", "Usuário ou senha incorretos.");
        }
      })
      .catch(() => setError(formLogin, "general", "Erro de comunicação."));
  });

  /* CRIAR CONTA */
  const formCriar = document.getElementById("form-criar");
  formCriar?.addEventListener("submit", e => {
    e.preventDefault();

    clearErrors(formCriar);
    const fd        = new FormData(formCriar);
    const nome      = fd.get("name")?.trim();
    const sobrenome = fd.get("sobrenome")?.trim();
    const cpf       = fd.get("cpf")?.trim();
    const email     = fd.get("email")?.trim();
    const phone     = fd.get("phone")?.trim();
    const senha     = fd.get("password")?.trim();

    if (!nome)      return setError(formCriar, "name", "Informe o nome");
    if (!sobrenome) return setError(formCriar, "sobrenome", "Informe o sobrenome");
    if (!validateCPF(cpf)) return setError(formCriar, "cpf", "CPF inválido");
    if (!validateEmail(email)) return setError(formCriar, "email", "E-mail inválido");
    if (!phone) return setError(formCriar, "phone", "Informe o celular");
    if (!validatePassword(senha)) return setError(formCriar, "password", "Mínimo 6 caracteres");

    fetch("ajax/criar-conta.php", { method: "POST", body: fd })
      .then(r => r.json())
      .then(data => {
        if (data.status === "ok") {
          alert("Conta criada com sucesso! Faça login.");
          hide(popupCriar);
          openFlex(popupLogin);
          return;
        }

        if (data.errors) {
          Object.entries(data.errors).forEach(([k, msg]) =>
            setError(formCriar, k, msg)
          );
        } else {
          setError(formCriar, "general", "Erro ao criar conta.");
        }
      })
      .catch(() => setError(formCriar, "general", "Erro de comunicação."));
  });

});
