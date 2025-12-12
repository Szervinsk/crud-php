<?php
session_start();
require 'Config.php'; // carrega agora a classe

$pdo = Config::getConexao();
$sql = $pdo->query("SELECT * FROM usuarios");

// lista de listas com todos os usuários
$usuarios = $sql->fetchAll(PDO::FETCH_ASSOC);

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
    <?php include('mensagem.php') ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Lista de Usuários
                            <a class="btn btn-primary float-end" href="cadastro.php">Adicionar usuário</a>
                        </h4>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Data de cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (count($usuarios) > 0): ?>

                                    <?php foreach ($usuarios as $usuario): ?>
                                        <tr>
                                            <td><?= $usuario['id']; ?></td>
                                            <td><?= $usuario['nome']; ?></td>
                                            <td><?= $usuario['email'] ?></td>
                                            <td><?= $usuario['data_cadastro'] ?></td>
                                            <td>
                                                <a href="visualizar.php?id=<?= $usuario['id']; ?>" class="btn btn-secondary btn-sm">Visualizar</a>
                                                <a href="editar.php?id=<?= $usuario['id']; ?>" class="btn btn-success btn-sm">Editar</a>

                                                <form action="excluir.php" method="POST" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                                    <input type="hidden" name="id" value="<?= $usuario['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                                                </form>
                                            </td>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">Não foram encontrados nenhum usuário</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>

    </h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>

</html>