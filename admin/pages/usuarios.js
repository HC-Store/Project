console.log("usuarios.js carregado");

function excluirUsuario(id) {
    if (!confirm("Tem certeza que deseja excluir este usuário?")) return;

    fetch("pages/usuarios_actions.php", {
        method: "POST",
        body: new URLSearchParams({
            action: "delete",
            id: id
        })
    })
    .then(r => r.json())
    .then(json => {
        if (json.success) {
            alert("Usuário excluído!");
            document.dispatchEvent(new Event("reload-page")); // SPA recarregar página
        } else {
            alert("Erro: " + json.message);
        }
    });
}

function abrirAdicionarUsuario() {
    alert("Aqui podemos abrir um modal de cadastro");
}
