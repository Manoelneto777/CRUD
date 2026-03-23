<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Captura o parâmetro "id" enviado pela URL
 * e valida se ele é um número inteiro válido.
 *
 * Exemplo de URL:
 * edit.php?id=3
 */
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

/**
 * Se o ID não for válido, o script é interrompido.
 */
if (!$id) {
    die("ID inválido.");
}

/**
 * Obtém a conexão com o banco de dados.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a consulta SQL para buscar apenas um usuário
 * com o ID informado.
 *
 * LIMIT 1 reforça que apenas um registro será retornado.
 */
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");

/**
 * Executa a consulta, passando o valor do ID.
 */
$stmt->execute([":id" => $id]);

/**
 * Busca o primeiro registro encontrado.
 * Como o ID é único, esperamos apenas um usuário.
 */
$user = $stmt->fetch();

/**
 * Se nenhum aluno for encontrado, interrompe a execução.
 */
if (!$user) {
    die("Aluno não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Aluno</title>
</head>

<body class="bg-slate-900 text-white min-h-screen flex items-center justify-center">

<div class="w-full max-w-xl bg-slate-800 p-6 rounded-xl shadow-lg">

    <h1 class="text-2xl font-bold text-center mb-6">
        ✏️ Editar Aluno
    </h1>

    <!--
        Formulário de atualização
        O botão não envia direto — primeiro abre o modal
    -->
    <form id="formUpdate" action="update.php" method="post" class="space-y-4">

        <!-- ID oculto -->
        <input type="hidden" name="id" value="<?= $user["id"] ?>">

        <!-- Nome -->
        <div>
            <label class="block mb-1 font-semibold">Nome</label>
            <input
                type="text"
                name="name"
                value="<?= htmlspecialchars($user["name"]) ?>"
                required
                class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-green-500"
            >
        </div>

        <!-- Documento -->
        <div>
            <label class="block mb-1 font-semibold">Documento</label>
            <input
                type="text"
                name="document"
                value="<?= htmlspecialchars($user["document"]) ?>"
                required
                class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-green-500"
            >
        </div>

        <!-- Curso -->
        <div>
            <label class="block mb-1 font-semibold">Curso</label>
            <input
                type="text"
                name="curso"
                value="<?= htmlspecialchars($user["curso"]) ?>"
                required
                class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:ring-2 focus:ring-green-500"
            >
        </div>

        <!-- Botões -->
        <div class="flex gap-2">

            <!-- Botão que abre o modal -->
            <button
                type="button"
                onclick="abrirModal()"
                class="flex-1 bg-green-500 hover:bg-green-600 transition p-2 rounded font-bold"
            >
                Atualizar
            </button>

            <!-- Voltar -->
            <a
                href="index.php"
                class="flex-1 text-center bg-slate-600 hover:bg-slate-700 transition p-2 rounded font-bold"
            >
                Voltar
            </a>

        </div>

    </form>

</div>
<!-- 🔥 MODAL DE CONFIRMAÇÃO -->
<div id="modalConfirm"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <div class="bg-slate-800 p-6 rounded-lg shadow-lg w-80 text-center">

        <h2 class="text-lg font-bold mb-4">
            Confirmar atualização
        </h2>

        <p class="text-slate-300 mb-6">
            Tem certeza que deseja atualizar os dados deste aluno?
        </p>

        <div class="flex gap-2">

            <!-- Confirmar -->
            <button
                onclick="confirmarUpdate()"
                class="flex-1 bg-green-500 hover:bg-green-600 p-2 rounded"
            >
                Confirmar
            </button>

            <!-- Cancelar -->
            <button
                onclick="fecharModal()"
                class="flex-1 bg-slate-600 hover:bg-slate-700 p-2 rounded"
            >
                Cancelar
            </button>

        </div>

    </div>

</div>


<!-- 🔥 TOAST DE SUCESSO -->
<div id="toastSuccess"
     class="fixed top-5 right-5 bg-green-500 text-white px-4 py-3 rounded shadow-lg hidden">

    Aluno atualizado com sucesso ✔

</div>


<script>

/**
 * Abre o modal de confirmação
 */
function abrirModal() {
    document.getElementById("modalConfirm").classList.remove("hidden");
    document.getElementById("modalConfirm").classList.add("flex");
}

/**
 * Fecha o modal
 */
function fecharModal() {
    document.getElementById("modalConfirm").classList.add("hidden");
}

/**
 * Confirma o envio do formulário
 */
function confirmarUpdate() {
    document.getElementById("formUpdate").submit();
}

/**
 * Exibe o toast caso exista parâmetro ?updated=1
 */
const params = new URLSearchParams(window.location.search);

if (params.get("updated") === "1") {

    const toast = document.getElementById("toastSuccess");

    toast.classList.remove("hidden");

    setTimeout(() => {
        toast.classList.add("hidden");
    }, 3000);
}

</script>

</body>
</html>