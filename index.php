<?php
require __DIR__ . "/connect.php";

/**
 * Obtém a instância única da conexão (Singleton).
 */
$pdo = Connect::getInstance();

/**
 * Executa a consulta para buscar todos os usuários
 * ordenados pelo ID (do menor para o maior).
 */
$stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");

/**
 * Armazena todos os registros em um array associativo.
 */
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Configuração de caracteres -->
    <meta charset="UTF-8">

    <!-- Responsividade para dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CRUD de Alunos</title>

    <style>
        
        body {
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #fff;
            margin: 0;
            padding: 20px;
        }

        /**
         * Container centralizado
         */
        .container {
            max-width: 900px;
            margin: auto;
        }

        /**
         * Títulos centralizados
         */
        h1, h2 {
            text-align: center;
        }

        /**
         * Estilização do formulário
         */
        form {
            background: #1e293b;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        /**
         * Labels em destaque
         */
        label {
            font-weight: bold;
        }

        /**
         * Inputs com espaçamento e borda suave
         */
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: none;
        }

        /**
         * Botão principal
         */
        button {
            background: #22c55e;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        /**
         * Efeito ao passar o mouse no botão
         */
        button:hover {
            background: #16a34a;
        }

        /**
         * Estilização da tabela
         */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #1e293b;
            border-radius: 10px;
            overflow: hidden;
        }

        /**
         * Cabeçalho e células
         */
        th, td {
            padding: 10px;
            text-align: center;
        }

        /**
         * Cor do cabeçalho
         */
        th {
            background: #334155;
        }

        /**
         * Linhas alternadas (efeito zebra)
         */
        tr:nth-child(even) {
            background: #0f172a;
        }

        /**
         * Links
         */
        a {
            color: #38bdf8;
            text-decoration: none;
        }

        /**
         * Efeito hover nos links
         */
        a:hover {
            text-decoration: underline;
        }

        /**
         * Espaçamento entre ações
         */
        .actions a {
            margin: 0 5px;
        }
    </style>
</head>

<body>
<div class="max-w-3xl mx-auto bg-slate-800 p-6 rounded-xl shadow-lg">
    
    <h1 class="text-2xl font-bold text-center mb-6">Cadastro de Alunos</h1>

    <form action="store.php" method="post" class="space-y-4">

        <div>
            <label class="block mb-1 font-semibold">Nome</label>
            <input type="text" name="name"
                class="w-full p-2 rounded bg-slate-700 border border-slate-600 focus:outline-none focus:ring-2 focus:ring-green-500"
                required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Documento</label>
            <input type="text" name="document"
                class="w-full p-2 rounded bg-slate-700 border border-slate-600">
        </div>

        <div>
            <label class="block mb-1 font-semibold">Curso</label>
            <input type="text" name="curso"
                class="w-full p-2 rounded bg-slate-700 border border-slate-600">
        </div>

        <button
            class="w-full bg-green-500 hover:bg-green-600 transition p-2 rounded font-bold">
            Cadastrar
        </button>

    </form>
</div>

    <!-- Subtítulo -->
    <h2>Lista de alunos</h2>

    <!-- Tabela de usuários -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Documento</th>
                <th>Curso</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>
            <!-- Percorre todos os usuários -->
            <?php foreach ($users as $user) : ?>
                <tr>

                    <!-- ID -->
                    <td><?= htmlspecialchars($user["id"]) ?></td>

                    <!-- Nome protegido contra XSS -->
                    <td><?= htmlspecialchars($user["name"]) ?></td>

                    <!-- Documento -->
                    <td><?= htmlspecialchars($user["document"]) ?></td>

                    <!-- Curso (se não existir, mostra '-') -->
                    <td><?= htmlspecialchars($user["curso"] ?? '-') ?></td>

                    <!-- Data formatada -->
                    <td><?= date("d/m/Y H:i", strtotime($user["created_at"])) ?></td>

                    <!-- Ações -->
                    <td class="actions">

                        <!-- Editar -->
                        <a href="edit.php?id=<?= $user["id"] ?>">Editar</a>

                        <!-- Excluir com confirmação -->
                        <a href="delete.php?id=<?= $user["id"] ?>"
                           onclick="return confirm('Excluir este aluno?')">
                           Excluir
                        </a>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

        <tfoot>
            <tr>
                <!-- Total de registros -->
                <td colspan="6">
                    Total: <?= count($users) ?> alunos
                </td>
            </tr>
        </tfoot>
    </table>

</div>

</body>
</html>