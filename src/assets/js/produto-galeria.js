// Troca de imagem principal
document.querySelectorAll(".miniaturas img").forEach(img => {
  img.addEventListener("click", () => {
    const principal = document.getElementById("imagem-principal");
    principal.src = img.src;
  });
});

// Dropdowns (favoritos, sacola, login)
function fecharTodosDropdowns() {
  document.querySelectorAll(".dropdown-panel, .dropdown-mini").forEach(el => el.style.display = "none");
}

document.addEventListener("click", e => {
  if (!e.target.closest(".user-menu")) fecharTodosDropdowns();
});

document.querySelectorAll(".user-menu button").forEach(btn => {
  btn.addEventListener("click", e => {
    e.stopPropagation();
    const menu = btn.parentElement.querySelector(".dropdown-panel, .dropdown-mini");
    const aberto = menu.style.display === "block";
    fecharTodosDropdowns();
    menu.style.display = aberto ? "none" : "block";
  });
});