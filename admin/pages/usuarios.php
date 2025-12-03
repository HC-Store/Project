<?php
require_once __DIR__ . '/../../conexao.php';

$usuarios = $pdo->query("
    SELECT id, nome, email, tipo, criado_em
    FROM usuarios
    ORDER BY id DESC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="pages/usuarios.css">

<div class="usuarios-header">

    <div>
        <h1>Lista de Usuários</h1>
        <p class="breadcrumb">Home > Usuários</p>
    </div>

    <button class="btn-add-user" onclick="excluirSelecionados()">
    EXCLUIR SELECIONADOS
</button>


</div>


<section class="card usuarios-table">

    <h3>Usuários Cadastrados</h3>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Criado Em</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($usuarios as $u): ?>
            <tr>

                <td>#<?= $u['id'] ?></td>

                <td><?= htmlspecialchars($u['nome']) ?></td>

                <td><?= htmlspecialchars($u['email']) ?></td>

                <td><?= ucfirst($u['tipo']) ?></td>

                <td><?= date("d/m/Y H:i", strtotime($u['criado_em'])) ?></td>

                <td>
                    <button class="btn-del" onclick="excluirUsuario(<?= $u['id'] ?>)">
                        Excluir
                    </button>
                </td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</section>

<script src="pages/usuarios.js"></script>
