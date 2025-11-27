// ===== DROPDOWNS (já estavam) =====
(function(){
  function closeAllDD() {
    document.querySelectorAll('.dropdown-panel, .dropdown-mini').forEach(el => el.style.display = 'none');
  }
  document.addEventListener('click', e => { if (!e.target.closest('.user-menu')) closeAllDD(); });
  document.querySelectorAll('.user-menu .icon-btn').forEach(btn => {
    btn.addEventListener('click', e => {
      e.stopPropagation();
      const id = btn.id.replace('-icon','-dropdown');
      const dd = document.getElementById(id);
      if (!dd) return;
      const show = dd.style.display !== 'block';
      closeAllDD();
      dd.style.display = show ? 'block' : 'none';
    });
  });
})();

// ===== POPUPS LOGIN / CRIAR CONTA =====
(function(){
  const popupLogin = document.getElementById('popup-login');
  const popupCriar = document.getElementById('popup-criar');
  const btnEntrar  = document.getElementById('btn-entrar');
  const btnCriar   = document.getElementById('btn-criar');
  const linkLogin  = document.getElementById('link-login');
  const linkCriar  = document.getElementById('link-criar');

  function openLogin(){ popupCriar?.classList.remove('active'); popupLogin?.classList.add('active'); }
  function openCriar(){ popupLogin?.classList.remove('active'); popupCriar?.classList.add('active'); }

  // abrir pelo dropdown
  btnEntrar?.addEventListener('click', e => { e.stopPropagation(); document.getElementById('user-dropdown').style.display='none'; openLogin(); });
  btnCriar ?.addEventListener('click', e => { e.stopPropagation(); document.getElementById('user-dropdown').style.display='none'; openCriar(); });

  // trocar entre popups
  linkLogin?.addEventListener('click', e => { e.preventDefault(); openLogin(); });
  linkCriar?.addEventListener('click', e => { e.preventDefault(); openCriar(); });

  // fechar clicando fora
  [popupLogin, popupCriar].forEach(pop => {
    if (!pop) return;
    pop.addEventListener('click', e => { if (e.target === pop) pop.classList.remove('active'); });
  });

  // ESC fecha
  document.addEventListener('keydown', e => { if (e.key === 'Escape'){ popupLogin?.classList.remove('active'); popupCriar?.classList.remove('active'); }});


})();


// ===== EXIBIR/ALTERNAR MÉTODOS DE PAGAMENTO =====
(function(){
  const btnSel = document.getElementById('btn-selecionar');
  const boxMetodos = document.getElementById('metodos');
  const painelCartao = document.getElementById('painel-cartao');
  const painelBoleto = document.getElementById('painel-boleto');
  const painelPix = document.getElementById('painel-pix');

  if (btnSel && boxMetodos) {
    btnSel.addEventListener('click', () => {
      boxMetodos.style.display = (boxMetodos.style.display === 'none' || boxMetodos.style.display === '') ? 'flex' : 'none';
    });
  }

  function showPainel(method) {
    if (painelCartao) painelCartao.style.display = method === 'cartao' ? 'block' : 'none';
    if (painelBoleto) painelBoleto.style.display = method === 'boleto' ? 'block' : 'none';
    if (painelPix)    painelPix.style.display    = method === 'pix'    ? 'block' : 'none';
  }

  if (boxMetodos) {
    boxMetodos.addEventListener('change', e => {
      if (e.target.name === 'pagamento') showPainel(e.target.value);
    });
  }
})();

// ===== PIX - copiar payload (quando existir) =====
(function(){
  const btnCopy = document.getElementById('btn-copy-pix');
  if (!btnCopy) return;
  btnCopy.addEventListener('click', () => {
    const ta = document.querySelector('.codebox');
    if (!ta) return;
    ta.select();
    document.execCommand('copy');
    btnCopy.textContent = 'Copiado!';
    setTimeout(() => (btnCopy.textContent = 'Copiar'), 1500);
  });
})();

// ===== Atualiza resumo (visual) – já calculado no PHP =====
(function hydrateResumo(){
  const box = document.getElementById('pedido-box');
  if (!box) return;
  const subtotal = parseFloat(box.dataset.subtotal || '0');
  const frete    = parseFloat((box.dataset.frete || '0'));
  const desc     = parseFloat(box.dataset.desconto || '0');
  const total    = Math.max(0, subtotal - desc) + (isNaN(frete) ? 0 : frete);
  const rTot = document.getElementById('r-total');
  if (rTot) rTot.textContent = 'R$ ' + total.toFixed(2).replace('.', ',');
})();
// abrir / fechar popups
const popLogin = document.getElementById("popup-login");
const popCriar = document.getElementById("popup-criar");

function openLogin(){ popCriar.classList.remove("active"); popLogin.classList.add("active"); }
function openCriar(){ popLogin.classList.remove("active"); popCriar.classList.add("active"); }

document.getElementById("btn-entrar")?.addEventListener("click", () => {
  document.getElementById("user-dropdown").style.display = "none";
  openLogin();
});
document.getElementById("btn-criar")?.addEventListener("click", () => {
  document.getElementById("user-dropdown").style.display = "none";
  openCriar();
});

// links internos
document.getElementById("link-criar")?.addEventListener("click", (e) => {
  e.preventDefault();
  openCriar();
});
document.getElementById("link-login")?.addEventListener("click", (e) => {
  e.preventDefault();
  openLogin();
});

// fechar clicando fora
[popLogin, popCriar].forEach(p => {
  p.addEventListener("click", e => {
    if (e.target === p) p.classList.remove("active");
  });
});

