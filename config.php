<?php 
// config.php

$caminhoBanco = __DIR__ . '/banco.sqlite';

try {
    // 2. CORREÇÃO DA CONEXÃO: 
    $pdo = new PDO('sqlite:' . $caminhoBanco);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT NOT NULL,
    email TEXT NOT NULL, 
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
    )";

    $pdo->exec($query);
    
} catch (PDOException $e) {
    echo "Erro na conexão:" . $e->getMessage();
    exit;
}
?>