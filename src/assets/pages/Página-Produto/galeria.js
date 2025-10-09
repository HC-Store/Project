const imagemPrincipal = document.getElementById("imagem-principal");
const miniaturas = document.querySelectorAll(".miniaturas img");

miniaturas.forEach(mini => {
  mini.addEventListener("click", () => {
    imagemPrincipal.src = mini.src;
    imagemPrincipal.alt = mini.alt;
  });
});
