<?php

/**
 * Inclui a conexão com o banco de dados.
 */
require __DIR__ . "/connect.php";

/**
 * Função auxiliar para limpar dados de entrada.
 */
function cleanInput($data)
{
    return trim($data ?? "");
}

/**
 * Captura e limpa os dados do formulário.
 */
$name = cleanInput($_POST["name"] ?? null);
$document = cleanInput($_POST["document"] ?? null);
$curso = cleanInput($_POST["curso"] ?? null);

/**
 * Validação básica dos campos obrigatórios.
 */
if ($name === "" || $document === "" || $curso === "") {
    die("Preencha todos os campos.");
}

/**
 * Validação adicional (boas práticas).
 */
if (strlen($name) < 3) {
    die("Nome deve ter pelo menos 3 caracteres.");
}

/**
 * Conexão com o banco.
 */
$pdo = Connect::getInstance();

/**
 * Prepara a inserção (seguro contra SQL Injection).
 */
$stmt = $pdo->prepare("
    INSERT INTO users (name, document, curso)
    VALUES (:name, :document, :curso)
");

/**
 * Executa a query com os dados.
 */
$stmt->execute([
    ":name" => $name,
    ":document" => $document,
    ":curso" => $curso
]);

/**
 * Redireciona para a página principal.
 */
header("Location: index.php");
exit;