<?php

/**
 * Inclui o arquivo de conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Função auxiliar para limpar dados de entrada.
 * Remove espaços desnecessários.
 */
function cleanInput($data)
{
    return trim($data ?? "");
}

/**
 * Captura e valida o ID enviado via POST.
 * FILTER_VALIDATE_INT garante que seja um número inteiro válido.
 */
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

/**
 * Captura e limpa os dados do formulário.
 */
$name = cleanInput($_POST["name"] ?? null);
$document = cleanInput($_POST["document"] ?? null);
$curso = cleanInput($_POST["curso"] ?? null);

/**
 * Validação dos dados:
 * - ID deve ser válido
 * - Campos não podem estar vazios
 */
if (!$id || $name === "" || $document === "" || $curso === "") {
    die("Dados inválidos.");
}

/**
 * Validação adicional (boas práticas)
 */
if (strlen($name) < 3) {
    die("Nome deve ter pelo menos 3 caracteres.");
}

/**
 * Obtém a conexão com o banco de dados.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a instrução SQL de atualização.
 * Apenas os campos corretos são atualizados.
 */
$stmt = $pdo->prepare("
    UPDATE users
    SET 
        name = :name,
        document = :document,
        curso = :curso
    WHERE id = :id
");

/**
 * Executa a query com os dados tratados.
 */
$stmt->execute([
    ":id" => $id,
    ":name" => $name,
    ":document" => $document,
    ":curso" => $curso
]);

/**
 * Redireciona para a página principal após atualização.
 */
header("Location: index.php?updated=1");

/**
 * Encerra a execução do script.
 */
exit;