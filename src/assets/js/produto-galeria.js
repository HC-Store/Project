document.addEventListener("DOMContentLoaded", () => {

  /* =====================================================
       FUNÇÕES DE SUPORTE
  ===================================================== */
  const openFlex = el => el && (el.style.display = "flex");
  const hide = el => el && (el.style.display = "none");

  let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];
  let sacola = JSON.parse(localStorage.getItem("sacola")) || [];

  const salvarFavoritos = () =>
    localStorage.setItem("favoritos", JSON.stringify(favoritos));
    
  const salvarSacola = () =>
    localStorage.setItem("sacola", JSON.stringify(sacola));

  /* =====================================================
       IMAGEM PRINCIPAL + MINIATURAS
  ===================================================== */
  const principal = document.getElementById("imagem-principal");

  if (principal) {
    const fallbackImg = "../src/assets/image/sem-foto.svg";
    if (!principal.src || principal.src.includes("null")) {
      principal.src = fallbackImg;
    }
  }

  document.querySelectorAll(".miniaturas img").forEach(img => {
    img.addEventListener("click", () => {
      if (principal) principal.src = img.src;
    });

    // fallback da miniatura
    if (!img.src || img.src.includes("null")) {
      img.src = "../src/assets/image/sem-foto.svg";
    }
  });

  /* =====================================================
       DADOS DO PRODUTO DA PÁGINA
  ===================================================== */
  const nomeProd =
    document.querySelector(".titulo-prod")?.textContent.trim() || "Produto";
  const precoProd =
    document.querySelector(".preco strong")?.textContent.trim() || "R$ 0,00";
  const imgProd = principal?.src || "../src/assets/image/sem-foto.svg";

  /* =====================================================
       BOTÃO - FAVORITAR
  ===================================================== */
  const btnFav = document.getElementById("btn-add-favorito");

  btnFav?.addEventListener("click", () => {
    const existe = favoritos.some(p => p.nome === nomeProd);

    if (!existe) {
      favoritos.push({ nome: nomeProd, preco: precoProd, img: imgProd });
      salvarFavoritos();
    }

    // animação simples
    btnFav.style.transform = "scale(1.2)";
    setTimeout(() => (btnFav.style.transform = "scale(1)"), 200);
  });

  /* =====================================================
       BOTÃO - ADICIONAR À SACOLA
  ===================================================== */
  const btnSacola = document.getElementById("btn-add-carrinho");

  btnSacola?.addEventListener("click", () => {
    sacola.push({ nome: nomeProd, preco: precoProd, img: imgProd });
    salvarSacola();

    // tenta abrir dropdown da sacola (se existir na página via header)
    const bagDropdown = document.getElementById("bag-dropdown");
    if (bagDropdown) openFlex(bagDropdown);
  });

  /* =====================================================
       BOTÃO - COMPRAR (vai pro checkout.php)
  ===================================================== */
  const btnComprar = document.getElementById("btn-comprar");

  btnComprar?.addEventListener("click", () => {
    const id = btnComprar.dataset.id;
    if (!id) return alert("Produto sem ID.");

    window.location.href = `checkout.php?id=${id}`;
  });

  /* =====================================================
       CARDS DE RELACIONADOS — VER MAIS
  ===================================================== */
  document.querySelectorAll(".card-produto button").forEach(btn => {
    btn.addEventListener("click", e => {
      e.preventDefault();

      const card = btn.closest(".card-produto");
      const categoria = card?.dataset?.cat || "";

      if (categoria.length > 0) {
        window.location.href = `lista-produtos.php?category=${encodeURIComponent(categoria)}`;
      } else {
        window.location.href = "lista-produtos.php";
      }
    });
  });

});

