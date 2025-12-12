<?php
session_start();
require 'Config.php';
$pdo = Config::getConexao();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

// 1. Verificação inicial: Se não tiver ID na URL, volta pro início
if (!$id) {
    $_SESSION['mensagem'] = "Usuário não encontrado!";
    header("Location: index.php");
    exit;
}

// 2. SQL Corrigido (sem parênteses nos campos)
$sql = $pdo->prepare("SELECT nome, email, data_cadastro FROM usuarios WHERE id = :id LIMIT 1");
$sql->bindValue(":id", $id);
$sql->execute();

// 3. Fetch Corrigido: Usamos fetch() para pegar UM único registro
$usuario = $sql->fetch(PDO::FETCH_ASSOC);

// 4. Verificação Secundária: O ID existe na URL, mas existe no banco?
if (!$usuario) {
    $_SESSION['mensagem'] = "Usuário não encontrado no banco de dados!";
    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Detalhes do Usuário
                            <a href="index.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="fw-bold">Nome:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($usuario['nome']); ?></p>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">E-mail:</label>
                            <p class="form-control-plaintext"><?= htmlspecialchars($usuario['email']); ?></p>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Data de Cadastro:</label>
                            <p class="form-control-plaintext">
                                <?= date('d/m/Y H:i', strtotime($usuario['data_cadastro'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>