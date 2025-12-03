document.addEventListener("DOMContentLoaded", () => {

  /* ===========================================
     TROCA DA IMAGEM PRINCIPAL
  =========================================== */
  const imagemPrincipal = document.getElementById("imagem-principal");
  const minis = document.querySelectorAll(".mini");

  minis.forEach(mini => {
    mini.addEventListener("click", () => {
      imagemPrincipal.src = mini.src;
    });
  });

  /* ===========================================
     ADICIONAR À SACOLA (LOCALSTORAGE)
  =========================================== */


  /* ===========================================
     BOTÃO COMPRAR
  =========================================== */
  const btnComprar = document.getElementById("btn-comprar");

  if (btnComprar) {
    btnComprar.addEventListener("click", () => {
      const id = btnComprar.dataset.id;
      window.location.href = "checkout.php?produto=" + id;
    });
  }

  /* ===========================================
     FAVORITO (LOCALSTORAGE)
  =========================================== */
  const btnFav = document.getElementById("btn-add-favorito");

  if (btnFav) {
    btnFav.addEventListener("click", () => {

      btnFav.classList.toggle("active");

      const nome  = document.querySelector(".titulo-prod")?.textContent.trim();
      const preco = document.querySelector(".preco strong")?.textContent.trim();
      const img   = document.getElementById("imagem-principal")?.src;

      let favoritos = JSON.parse(localStorage.getItem("favoritos")) || [];

      if (btnFav.classList.contains("active")) {
        favoritos.push({ nome, preco, img });
        alert("Adicionado aos favoritos!");
      } else {
        favoritos = favoritos.filter(p => p.nome !== nome);
      }

      localStorage.setItem("favoritos", JSON.stringify(favoritos));
    });
  }

});
