/* ============================================================
   ESTADO
============================================================ */
const state = {
    produto_id: null,
    files: []
};

/* ============================================================
   ELEMENTOS
============================================================ */
const fileInput   = document.getElementById("file-multiple");
const uploadArea  = document.getElementById("upload-area");
const uploadList  = document.getElementById("upload-list");
const preview     = document.getElementById("main-image");

/* ============================================================
   SELECIONAR ARQUIVOS
============================================================ */
document.getElementById("select-btn").onclick = () => fileInput.click();

fileInput.onchange = (e) => {
    handleFiles(e.target.files);
};

/* ============================================================
   DRAG & DROP
============================================================ */
uploadArea.ondragover = (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = "#3b82f6";
};

uploadArea.ondragleave = () => {
    uploadArea.style.borderColor = "#bbb";
};

uploadArea.ondrop = (e) => {
    e.preventDefault();
    uploadArea.style.borderColor = "#bbb";
    handleFiles(e.dataTransfer.files);
};

/* ============================================================
   PROCESSAR ARQUIVOS
============================================================ */
function handleFiles(files) {
    [...files].forEach(file => {

        if (!["image/png", "image/jpeg", "image/webp"].includes(file.type)) {
            alert("Formato inválido!");
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert("Máximo permitido: 5MB");
            return;
        }

        const id = "f" + Math.random().toString(36).substring(2, 10);

        state.files.push({ id, file });

        addUploadItem(id, file);

        // preview principal
        preview.src = URL.createObjectURL(file);
    });
}

/* ============================================================
   CRIA ITEM VISUAL NA LISTA
============================================================ */
function addUploadItem(id, file) {

    const row = document.createElement("div");
    row.className = "upload-item";
    row.id = "item_" + id;

    row.innerHTML = `
        <img class="upload-thumb" src="${URL.createObjectURL(file)}">

        <div class="upload-info">
            <div class="name">${file.name}</div>

            <div class="progress">
                <div class="progress-bar" id="bar_${id}"></div>
            </div>
        </div>

        <div class="upload-check" id="check_${id}" style="opacity:0;">
            ✔
        </div>
    `;

    uploadList.appendChild(row);
}

/* ============================================================
   CONTADOR DE DESCRIÇÃO
============================================================ */
document.getElementById("descricao").oninput = (e) => {
    const v = e.target.value;
    if (v.length > 500) e.target.value = v.slice(0, 500);
    document.getElementById("contador-desc").textContent =
        e.target.value.length + "/500";
};

/* ============================================================
   MÁSCARA DE MOEDA
============================================================ */
function maskMoney(input) {
    let v = input.value.replace(/\D/g, "");
    v = (v / 100).toFixed(2).replace(".", ",");
    input.value = "R$ " + v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

document.getElementById("preco_normal").oninput = e => maskMoney(e.target);
document.getElementById("preco_venda").oninput  = e => maskMoney(e.target);

/* ============================================================
   BOTÃO CANCELAR
============================================================ */
document.getElementById("btn-cancelar").onclick = () => {
    if (confirm("Cancelar e limpar tudo?")) {
        window.location.reload();
    }
};

/* ============================================================
   BOTÃO ADICIONAR
============================================================ */
document.getElementById("btn-salvar").onclick = async () => {

    const nome    = document.getElementById("nome").value.trim();
    const precoV  = document.getElementById("preco_venda").value.trim();

    if (!nome) {
        alert("Preencha o nome do produto");
        return;
    }

    if (!precoV) {
        alert("Preencha o preço de venda");
        return;
    }

    const form = new FormData();
    form.append("action", "create_product");
    form.append("nome", nome);
    form.append("descricao", document.getElementById("descricao").value);
    form.append("categoria", document.getElementById("categoria").value);
    form.append("marca", document.getElementById("marca").value);
    form.append("numero_estoque", document.getElementById("numero_estoque").value);
    form.append("quantidade", document.getElementById("quantidade").value);
    form.append("preco_normal", document.getElementById("preco_normal").value);
    form.append("preco_venda", document.getElementById("preco_venda").value);

    // DESABILITA O BOTÃO
    const btn = document.getElementById("btn-salvar");
    btn.disabled = true;
    btn.textContent = "Salvando...";

    // ENVIA PARA O PHP NO CAMINHO CORRETO
    const res = await fetch("pages/adicionar.php", {
        method: "POST",
        body: form
    });

    const json = await res.json();

    if (!json.success) {
        alert("Erro: " + json.message);
        btn.disabled = false;
        btn.textContent = "ADICIONAR";
        return;
    }

    state.produto_id = json.produto_id;

    if (state.files.length === 0) {
        finishSuccess();
        return;
    }

    for (const f of state.files) {
        await uploadImage(f);
    }

    finishSuccess();
};

/* ============================================================
   UPLOAD INDIVIDUAL
============================================================ */
function uploadImage(entry) {

    return new Promise(resolve => {

        const bar   = document.getElementById("bar_" + entry.id);
        const check = document.getElementById("check_" + entry.id);

        const xhr  = new XMLHttpRequest();
        const form = new FormData();

        form.append("action", "upload_image");
        form.append("produto_id", state.produto_id);
        form.append("image", entry.file);

        xhr.upload.onprogress = (e) => {
            if (e.lengthComputable) {
                const pct = (e.loaded / e.total) * 100;
                bar.style.width = pct + "%";
            }
        };

        xhr.onload = () => {
            try {
                const json = JSON.parse(xhr.responseText);

                if (json.success) {
                    bar.style.width = "100%";
                    check.style.opacity = "1";
                }
            } catch (e) {
                console.error("Erro no retorno do upload:", xhr.responseText);
            }

            resolve();
        };

        xhr.open("POST", "pages/adicionar.php");
        xhr.send(form);
    });
}

/* ============================================================
   FINALIZAÇÃO
============================================================ */
function finishSuccess() {
    document.getElementById("mensagem").innerHTML =
        `<p class="msg">Produto cadastrado com sucesso!</p>`;

    const btn = document.getElementById("btn-salvar");
    btn.textContent = "ADICIONADO";
    btn.disabled = true;
}
