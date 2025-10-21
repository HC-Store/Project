//JAVASCRIPTT PARA APARECER E SUMIR AS CATEGORIAS 

const btnCategorias = document.querySelector('.sidebar-menu button:nth-child(3)');
const listaCategorias = document.querySelector('.lista-categorias');

btnCategorias.addEventListener('click', () => {
  listaCategorias.classList.toggle('ativo');
});