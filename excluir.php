<?php 
// 1. Iniciar Sessão (Obrigatório em TODOS os arquivos que usam $_SESSION)
session_start();
require 'Config.php';
$pdo = Config::getConexao();

// Se o botão veio de um formulário POST, usamos INPUT_POST
$id = filter_input(INPUT_POST, 'id');

// Se você estiver usando link (<a href="excluir.php?id=...">), use INPUT_GET:
// $id = filter_input(INPUT_GET, 'id');

if ($id) {
    // --- Passo A: Buscar o nome antes de excluir ---
    $sql = $pdo->prepare("SELECT nome FROM usuarios WHERE id = :id");
    $sql->bindValue(":id", $id);
    $sql->execute();
    
    // Pegamos o resultado. fetchColumn pega apenas o valor da primeira coluna (nome)
    $nomeUsuario = $sql->fetchColumn(); 

    // --- Passo B: Excluir ---
    $sql = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
    $sql->bindValue(":id", $id);
    
    if ($sql->execute()) {
        // Se o nome não for encontrado (ex: já deletado), usamos um termo genérico
        $nomeExibicao = $nomeUsuario ? $nomeUsuario : 'O usuário';
        
        $_SESSION['mensagem'] = "$nomeExibicao foi excluído com sucesso.";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir usuário.";
        header("Location: index.php");
        exit;
    }
} else {
    // Se tentarem acessar o arquivo sem ID
    $_SESSION['mensagem'] = "ID inválido.";
    header("Location: index.php");
    exit;
}
?>