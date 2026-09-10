<?php

require_once 'conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Produto não informado.");
}

$sql = "DELETE FROM produtos WHERE id = :id";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':id' => $id
]);

header("Location: listar.php");
exit;