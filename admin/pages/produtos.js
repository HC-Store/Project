function apagarSelecionados() {
    const selecionados = [...document.querySelectorAll(".produto-check:checked")]
        .map(e => e.value);

    if (selecionados.length === 0) {
        alert("Selecione pelo menos um produto para apagar.");
        return;
    }

    if (!confirm("Tem certeza que deseja APAGAR os produtos selecionados?")) return;

    fetch(window.location.origin + "/Project/admin/pages/apagar-produtos.php", {

        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ids: selecionados })
    })
    .then(r => r.json())
    .then(resp => {
        if (resp.success) {
            alert("Produtos apagados com sucesso!");
            carregarPagina("produtos");
        } else {
            alert("Erro: " + resp.message);
        }
    })
  
}
