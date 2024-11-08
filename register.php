<?php
session_start();
require 'conexao.php';

if (isset($_POST['register'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $tipo_usuario_id = trim($_POST['tipo_usuario']);
    $senha = trim($_POST['senha']);

    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($tipo_usuario_id) || empty($senha)) {
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos.';
    } else {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, data_nascimento, tipo_usuario_id, senha) 
                VALUES ('$nome', '$email', '$data_nascimento', '$tipo_usuario_id', '$senha_hash')";

        if (mysqli_query($conexao, $sql)) {
            $_SESSION['mensagem'] = 'Cadastro realizado com sucesso';
            header('Location: login.php');
            exit;
        } else {
            $_SESSION['mensagem'] = 'Erro: ' . mysqli_error($conexao);
        }
    }
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <?php if (isset($_SESSION['mensagem'])) { echo "<div class='alert alert-info'>" . $_SESSION['mensagem'] . "</div>"; unset($_SESSION['mensagem']); } ?>
        <div class="card">
            <div class="card-header"><h4>Cadastro de Usuário</h4></div>
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
                        <label>Data de Nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Tipo de Usuário</label>
                        <select name="tipo_usuario" class="form-control" required>
                            <option value="">Selecione o tipo de usuário</option>
                            <option value="1">Suporte</option>
                            <option value="2">Administrador</option>
                            <option value="3">Financeiro</option>
                            <option value="4">Desenvolvedor</option>
                            <option value="5">Gerente</option>
                            <option value="6">Atendente</option>
                            <option value="7">Visitante</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Senha</label>
                        <input type="password" name="senha" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="register" class="btn btn-dark">Cadastrar</button>
                        <a href="logout.php" class="btn btn-dark  float-end">Sair</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
