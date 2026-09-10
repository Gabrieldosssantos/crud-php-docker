<?php

require_once 'conexao.php';

$sql = "SELECT * FROM produtos ORDER BY id DESC";

$stmt = $pdo->query($sql);

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <h1>Lista de Produtos</h1>

        <a class="botao" href="cadastrar.php">
            ➕ Cadastrar novo produto
        </a>

        <table>

            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço</th>
                <th>Data de Cadastro</th>
                <th>Ações</th>
            </tr>

            <?php foreach ($produtos as $produto): ?>

                <tr>

                    <td><?= $produto['id'] ?></td>

                    <td><?= htmlspecialchars($produto['nome']) ?></td>

                    <td><?= htmlspecialchars($produto['descricao']) ?></td>

                    <td>
                        R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                    </td>

                    <td><?= $produto['data_cadastro'] ?></td>

                    <td>
                        <a href="editar.php?id=<?= $produto['id'] ?>">
                            Editar
                        </a>

                        |

                        <a
                            href="excluir.php?id=<?= $produto['id'] ?>"
                            onclick="return confirm('Tem certeza que deseja excluir este produto?')"
                        >
                            Excluir
                        </a>
                    </td>

                </tr>

            <?php endforeach; ?>

        </table>

        <br>

        <a href="index.php">Voltar ao início</a>

    </div>

</body>

</html>