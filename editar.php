<?php
session_start();
require 'Config.php';
$pdo = Config::getConexao();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// --- Verificações de Segurança (IGUAL AO SEU) ---
if (!$id) {
    $_SESSION['mensagem'] = "Usuário não encontrado!";
    header("Location: index.php");
    exit;
}

$sql = $pdo->prepare("SELECT nome, email, data_cadastro FROM usuarios WHERE id = :id LIMIT 1");
$sql->bindValue(":id", $id);
$sql->execute();
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    $_SESSION['mensagem'] = "Usuário não encontrado no banco de dados!";
    header("Location: index.php");
    exit;
}

// --- LÓGICA DE ATUALIZAÇÃO ---

// 1. CORREÇÃO: O método do formulário é POST, não UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // 2. CORREÇÃO: Sintaxe SQL de UPDATE (UPDATE tabela SET campo=:valor WHERE...)
    // Note que não usamos VALUES aqui.
    $sql = $pdo->prepare("UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id");
    
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);
    $sql->bindValue(':id', $id); // O $id vem lá de cima (do GET)

    if ($sql->execute()) {
        // 3. CORREÇÃO: Mensagem adequada
        $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar usuário!";
        header("Location: index.php");
        exit;
    }
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Editar Usuário
                            <a href="index.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="salvar_usuario" class="btn btn-primary">Salvar Alterações</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>