<?php

require_once 'conexao.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("Produto não informado.");
}

$sql = "SELECT * FROM produtos WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);

$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    die("Produto não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];

    $sql = "UPDATE produtos
            SET nome = :nome,
                descricao = :descricao,
                preco = :preco
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':nome' => $nome,
        ':descricao' => $descricao,
        ':preco' => $preco,
        ':id' => $id
    ]);

    echo "<p>Produto atualizado com sucesso!</p>";

    $produto['nome'] = $nome;
    $produto['descricao'] = $descricao;
    $produto['preco'] = $preco;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>Editar Produto</h1>

        <form method="POST">

            <label>Nome:</label>
            <input
                type="text"
                name="nome"
                value="<?= htmlspecialchars($produto['nome']) ?>"
                required
            >

            <br><br>

            <label>Descrição:</label>
            <textarea name="descricao"><?= htmlspecialchars($produto['descricao']) ?></textarea>

            <br><br>

            <label>Preço:</label>
            <input
                type="number"
                name="preco"
                step="0.01"
                value="<?= $produto['preco'] ?>"
                required
            >

            <br><br>

            <button type="submit">Salvar alterações</button>

        </form>

        <br>

        <a href="listar.php">Voltar para lista</a>

    </div>

</body>

</html>