<?php
// Adicione isto na primeira linha!
session_start();

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Dica de segurança: Use filter_input ou htmlspecialchars nos posts também
    $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // O restante do seu código estava ótimo:
    $sql = $pdo->prepare("INSERT INTO usuarios (nome, email) VALUES (:nome, :email)");
    $sql->bindValue(':nome', $nome);
    $sql->bindValue(':email', $email);

    if ($sql->execute()) {
        $_SESSION['mensagem'] = "Usuário criado com sucesso!";
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao salvar usuário!";
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
    <title>Crud em PHP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>
    <!-- para incluir coisa como se fossem os componentes usamos assim -->
    <?php include('navbar.php'); ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Cadastro de Usuários
                            <a href="index.php" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <button type="submit" name="salvar_usuario" class="btn btn-primary">Salvar Usuário</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>