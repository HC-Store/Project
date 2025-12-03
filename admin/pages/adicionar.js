/* ============================================================
   ESTADO GLOBAL
============================================================ */
const state = {
    produto_id: null,
    files: []
};

/* ============================================================
   ELEMENTOS
============================================================ */
const fileInput  = document.getElementById("file-multiple");
const uploadArea = document.getElementById("upload-area");
const uploadList = document.getElementById("upload-list");
const preview    = document.getElementById("main-image");


/* ============================================================
   BOTÃO "SELECIONAR"
============================================================ */
document.getElementById("select-btn").onclick = () => fileInput.click();

fileInput.onchange = (e) => handleFiles(e.target.files);


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
   PROCESSAR ARQUIVOS SELECIONADOS
============================================================ */
function handleFiles(files) {
    [...files].forEach(file => {

        if (!["image/jpeg", "image/png", "image/webp"].includes(file.type)) {
            alert("Formato inválido! Permitido: JPG, PNG, WEBP");
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert("Máximo permitido: 5MB");
            return;
        }

        const id = "f" + Math.random().toString(36).substring(2, 10);
        state.files.push({ id, file });

        addUploadItem(id, file);

        // define o preview principal
        preview.src = URL.createObjectURL(file);
    });
}


/* ============================================================
   CRIA ITEM VISUAL PARA UPLOAD LIST
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

        <div class="upload-check" id="check_${id}" style="opacity:0;">✔</div>
    `;

    uploadList.appendChild(row);
}


/* ============================================================
   CONTADOR DE DESCRIÇÃO
============================================================ */
document.getElementById("descricao").oninput = (e) => {
    const txt = e.target.value;
    if (txt.length > 500) e.target.value = txt.slice(0, 500);

    document.getElementById("contador-desc").textContent =
        `${e.target.value.length}/500`;
};


/* ============================================================
   MÁSCARA DE MOEDA
============================================================ */
function maskMoney(input) {
    let v = input.value.replace(/\D/g, "");
    v = (v / 100).toFixed(2).replace(".", ",");
    input.value = "R$ " + v.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

document.getElementById("preco_normal").oninput = (e) => maskMoney(e.target);
document.getElementById("preco_venda").oninput  = (e) => maskMoney(e.target);


/* ============================================================
   BOTÃO CANCELAR
============================================================ */
document.getElementById("btn-cancelar").onclick = () => {
    if (confirm("Cancelar e limpar tudo?")) {
        window.location.reload();
    }
};


/* ============================================================
   BOTÃO ADICIONAR PRODUTO
============================================================ */
document.getElementById("btn-salvar").onclick = async () => {

    const nome = document.getElementById("nome").value.trim();
    const preco_venda = document.getElementById("preco_venda").value.trim();

    if (!nome) return alert("Preencha o nome do produto!");
    if (!preco_venda) return alert("Preencha o preço de venda!");

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

    const btn = document.getElementById("btn-salvar");
    btn.disabled = true;
    btn.textContent = "Salvando...";

    // ENVIO PARA adicionar.php (CAMINHO CORRETO!)
    const res = await fetch("pages/adicionar.php", { method:"POST", body:form })


    const json = await res.json();

    if (!json.success) {
        alert("Erro: " + json.message);
        btn.disabled = false;
        btn.textContent = "ADICIONAR";
        return;
    }

    state.produto_id = json.produto_id;

    // se não tem imagens, finaliza
    if (state.files.length === 0) {
        return finishSuccess();
    }

    // envia todas as imagens
    for (const entry of state.files) {
        await uploadImage(entry);
    }

    finishSuccess();
};


/* ============================================================
   UPLOAD INDIVIDUAL DE IMAGEM
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

            let json;
            try {
                json = JSON.parse(xhr.responseText);
            } catch (e) {
                console.error("ERRO JSON:", xhr.responseText);
                alert("O servidor retornou HTML em vez de JSON. Verifique o início do adicionar.php.");
                resolve();
                return;
            }

            if (json.success) {
                bar.style.width = "100%";
                check.style.opacity = "1";
            } else {
                alert("Erro ao enviar imagem: " + json.message);
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
    btn.textContent = "ADICIONADO!";
    btn.disabled = true;
}
