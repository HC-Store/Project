//Faz aparecer menu categorias quando clicamos 
const btnCategorias = document.querySelector('.sidebar-menu button:nth-child(3)');
const listaCategorias = document.querySelector('.lista-categorias');

btnCategorias.addEventListener('click', () => {
  listaCategorias.classList.toggle('ativo');
});
// Dropdown do botão "Alterar status"
const dropdown = document.querySelector('.dropdown-status');
const botao = dropdown.querySelector('.alterar-status');

botao.addEventListener('click', (e) => {
  e.stopPropagation(); // evita fechar imediatamente
  dropdown.classList.toggle('ativo');
});

// Fecha o menu se clicar fora
document.addEventListener('click', () => {
  dropdown.classList.remove('ativo');
});

// Exemplo de ação ao clicar numa opção (você pode adaptar para PHP)
//dropdown.querySelectorAll('li').forEach(item => {
  //item.addEventListener('click', () => {
   // botao.textContent = `Status: ${item.textContent} ▼`;
   // dropdown.classList.remove('ativo');
  //});
//});
