<?php

require_once 'conexao.php';

$sql = "
    CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descricao TEXT,
        preco DECIMAL(10,2) NOT NULL,
        data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
    )
";

$pdo->exec($sql);

echo "<h1>Tabela criada com sucesso!</h1>";
echo "<p>A tabela produtos está pronta para receber os registros.</p>";