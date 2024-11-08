<?php
ob_start();
session_start();
require 'conexao.php';


if (isset($_POST['login'])) {
  $email = trim($_POST['email']);
  $senha = trim($_POST['senha']);

  if (empty($email) || empty($senha)) {
    $_SESSION['mensagem'] = 'Por favor, preencha todos os campos.';
  } else {
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $resultado = mysqli_query($conexao, $sql);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
      $usuario = mysqli_fetch_assoc($resultado);
      if (password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_tipo'] = $usuario['tipo_usuario_id'];
        session_regenerate_id(true);
        header('Location: index.php'); // Redireciona para a página principal após login
        exit;
      } else {
        $_SESSION['mensagem'] = 'Senha incorreta.';
      }
    } else {
      $_SESSION['mensagem'] = 'Usuário não encontrado.';
    }
  }
}
?>

<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background-image: url('images/backgound.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat; height: 100vh; margin: 0;">
  <div class="container mt-5" style="display: grid; place-items: center; max-width: 400px; height: 100vh;">
    <?php if (isset($_SESSION['mensagem'])) {
      echo "<div class='alert alert-danger'>" . $_SESSION['mensagem'] . "</div>";
      unset($_SESSION['mensagem']);
    } ?>
    <div style="display: flex; flex-direction: column; align-items: center;">
      <div class="card" style="width: 100%; max-width: 400px; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.2);">
        <div class="card-header">
          <h4>Acesse sua conta</h4>
        </div>
        <div class="card-body">
          <form action="" method="POST">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Senha</label>
              <input type="password" name="senha" class="form-control" required>
            </div>
            <div class="mb-3">
              <button type="submit" name="login" class="btn btn-dark">Entrar</button>
            </div>
          </form>
        </div>
      </div>
      <p class="text-primary mt-3 text-center">Não tem conta?  <a href="register.php" class="text-white">  Cadastre-se</a></p>
    </div>
  </div>
</body>

</html>