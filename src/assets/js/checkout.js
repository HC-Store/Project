document.addEventListener("DOMContentLoaded", () => {

  // ==============================
  // 1. BUSCAR CEP AUTOMÁTICO
  // ==============================
  function buscarCEP() {
    const cepInput = document.getElementById('cep');
    if (!cepInput) return;

    const cep = cepInput.value.replace(/\D/g, '');

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
        document.getElementById('bairro').value   = data.bairro     || '';
        document.getElementById('cidade').value   = data.localidade || '';
        document.getElementById('estado').value   = data.uf         || '';

        // Recalcula frete automático
        calcularFrete(data.localidade, data.uf);
      })
      .catch(() => alert('Erro ao buscar o CEP.'));
  }

  // deixa a função disponível no HTML
  window.buscarCEP = buscarCEP;



  // ==============================
  // 2. CUPOM (VISUAL)
  // ==============================
  const btnCupom   = document.getElementById('btn-aplicar-cupom');
  const inputCupom = document.getElementById('cupom');

  const subtotalEl = document.getElementById('subtotal');
  const freteEl    = document.getElementById('frete');
  const descontoEl = document.getElementById('desconto');
  const totalEl    = document.getElementById('total');

  if (btnCupom && inputCupom && subtotalEl && freteEl && descontoEl && totalEl) {

    function getNumber(el) {
      return parseFloat(el.dataset.valor || '0');
    }

    function setNumber(el, value) {
      el.dataset.valor = value.toFixed(2);
      el.textContent   = 'R$' + value.toFixed(2).replace('.', ',');
    }

    btnCupom.addEventListener('click', () => {
      const code = inputCupom.value.trim().toUpperCase();
      let subtotal = getNumber(subtotalEl);
      let frete    = getNumber(freteEl);
      let desconto = 0;

      if (!code) {
        alert('Digite um cupom.');
        return;
      }

      if (code === 'PRIMEIRA15') {
        desconto = subtotal * 0.15;
        alert('Cupom aplicado: 15% de desconto.');
      } else {
        alert('Cupom inválido.');
      }

      setNumber(descontoEl, desconto);

      const total = Math.max(0, subtotal - desconto + frete);
      setNumber(totalEl, total);
    });

  }



  // ==============================
  // 3. FRETE GRÁTIS SP
  // ==============================
  function calcularFrete(cidade, uf) {
    const subtotalVal = document.getElementById("subtotal-value")
      ? parseFloat(document.getElementById("subtotal-value").value)
      : 0;

    const entregaSpan = document.querySelector('.resumo-pedido p:nth-child(2) span');
    const totalSpan   = document.querySelector('.total span');

    if (!entregaSpan || !totalSpan) return;

    let total = subtotalVal;

    if (uf === 'SP' && subtotalVal >= 150) {
      entregaSpan.textContent = 'Grátis';
      totalSpan.textContent   = `R$${total.toFixed(2)}`;
    } else {
      entregaSpan.textContent = 'R$20,00';
      total += 20;
      totalSpan.textContent   = `R$${total.toFixed(2)}`;
    }
  }

  // deixa acessível no HTML
  window.calcularFrete = calcularFrete;



  // ==============================
  // 4. FINALIZAR PEDIDO
  // ==============================
  const btnFinalizar = document.querySelector('.btn-finalizar');

  if (btnFinalizar) {
    btnFinalizar.addEventListener('click', e => {
      e.preventDefault();

      const usuarioLogado = document.body.getAttribute("data-user");

      if (usuarioLogado === "0") {
        alert("Você precisa estar logado para finalizar o pedido.");
        return;
      }

      // Enviar para pagamento
      window.location.href = 'pagamento.php';
    });
  }

});

 
