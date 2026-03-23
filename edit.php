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

    <!-- Container principal centralizado -->
    <div class="w-full max-w-xl bg-slate-800 p-6 rounded-xl shadow-lg">

        <!-- Título -->
        <h1 class="text-2xl font-bold text-center mb-6">
            ✏️ Editar Aluno
        </h1>

        <!--
            Formulário responsável por atualizar os dados do aluno
        -->
        <form action="update.php" method="post" class="space-y-4">

            <!-- ID oculto -->
            <input type="hidden" name="id" value="<?= $user["id"] ?>">

            <!-- Nome -->
            <div>
                <label for="name" class="block mb-1 font-semibold">Nome</label>
                <input 
                    type="text" 
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($user["name"]) ?>"
                    required
                    class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <!-- Documento -->
            <div>
                <label for="document" class="block mb-1 font-semibold">Documento</label>
                <input 
                    type="text" 
                    id="document"
                    name="document"
                    value="<?= htmlspecialchars($user["document"]) ?>"
                    required
                    class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <!-- Curso -->
            <div>
                <label for="curso" class="block mb-1 font-semibold">Curso</label>
                <input 
                    type="text" 
                    id="curso"
                    name="curso"
                    value="<?= htmlspecialchars($user["curso"]) ?>"
                    required
                    class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                >
            </div>

            <!-- Botões -->
            <div class="flex gap-2">

                <!-- Atualizar -->
                <button 
                    type="submit"
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

</body>
</html>