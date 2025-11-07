// ==============================
// 1. DROPDOWNS DE HEADER
// ==============================
function fecharTodosDropdowns() {
    document.querySelectorAll('.dropdown-panel, .dropdown-mini').forEach(el => el.style.display = 'none');
    document.querySelectorAll('.popup').forEach(el => el.classList.remove('active'));
  }
  
  document.addEventListener('click', function (e) {
    if (!e.target.closest('.user-menu') && !e.target.closest('.popup')) {
      fecharTodosDropdowns();
    }
  });
  
  document.querySelectorAll('.user-menu .icon-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      const id = this.id.replace('-icon', '-dropdown');
      const dropdown = document.getElementById(id);
  
      const isVisible = dropdown.style.display === 'block';
      fecharTodosDropdowns();
      dropdown.style.display = isVisible ? 'none' : 'block';
    });
  });
  
  // ==============================
  // 2. POPUPS LOGIN / CRIAR CONTA
  // ==============================
  const popupLogin = document.getElementById('popup-login');
  const popupCriar = document.getElementById('popup-criar');
  const btnEntrar = document.getElementById('btn-entrar');
  const btnCriar = document.getElementById('btn-criar');
  const linkLogin = document.getElementById('link-login');
  const linkCriar = document.getElementById('link-criar');
  
  if (btnEntrar) {
    btnEntrar.addEventListener('click', () => {
      fecharTodosDropdowns();
      popupLogin.classList.add('active');
    });
  }
  
  if (btnCriar) {
    btnCriar.addEventListener('click', () => {
      fecharTodosDropdowns();
      popupCriar.classList.add('active');
    });
  }
  
  if (linkLogin) {
    linkLogin.addEventListener('click', e => {
      e.preventDefault();
      popupCriar.classList.remove('active');
      popupLogin.classList.add('active');
    });
  }
  
  if (linkCriar) {
    linkCriar.addEventListener('click', e => {
      e.preventDefault();
      popupLogin.classList.remove('active');
      popupCriar.classList.add('active');
    });
  }
  
  // ==============================
  // 3. BUSCAR CEP AUTOMÁTICO
  // ==============================
  function buscarCEP() {
    const cep = document.getElementById('cep').value.replace(/\D/g, '');
  
    if (cep.length !== 8) {
      alert('Por favor, insira um CEP válido com 8 dígitos.');
      return;
    }
  
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then(res => res.json())
      .then(data => {
        if (data.erro) {
          alert('CEP não encontrado.');
          return;
        }
  
        document.getElementById('endereco').value = data.logradouro || '';
        document.getElementById('bairro').value = data.bairro || '';
        document.getElementById('cidade').value = data.localidade || '';
        document.getElementById('estado').value = data.uf || '';
  
        calcularFrete(data.localidade, data.uf);
      })
      .catch(() => alert('Erro ao buscar o CEP.'));
  }
  
  // ==============================
  // 4. CUPOM DE DESCONTO E FRETE
  // ==============================
  function aplicarCupom() {
    const cupom = document.querySelector('.desconto input').value.trim().toUpperCase();
    const totalSpan = document.querySelector('.total span');
    let total = 136.99; // valor base do exemplo
  
    if (cupom === 'PRIMEIRA15') {
      const desconto = total * 0.15;
      total -= desconto;
      alert('Cupom aplicado com sucesso! 15% de desconto.');
    } else if (cupom !== '') {
      alert('Cupom inválido.');
    }
  
    totalSpan.textContent = `R$${total.toFixed(2)}`;
  }
  
  document.querySelector('.desconto button').addEventListener('click', aplicarCupom);
  
  // ==============================
  // 5. FRETE GRÁTIS SP
  // ==============================
  function calcularFrete(cidade, uf) {
    const totalSpan = document.querySelector('.total span');
    let total = 136.99; // valor base do exemplo
    const entrega = document.querySelector('.resumo-pedido p:nth-child(2) span');
  
    if ((uf === 'SP') && total >= 150) {
      entrega.textContent = 'Grátis';
      totalSpan.textContent = `R$${total.toFixed(2)}`;
      alert('Frete grátis para São Paulo em compras acima de R$150!');
    } else {
      entrega.textContent = 'R$6,99';
      total += 6.99;
      totalSpan.textContent = `R$${total.toFixed(2)}`;
    }
  }
  
  // ==============================
  // 6. FINALIZAR PEDIDO
  // ==============================
  document.querySelector('form button').addEventListener('click', e => {
    e.preventDefault();
    window.location.href = 'pagamento.php';
  }); 