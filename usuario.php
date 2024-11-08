<?php
session_start();
require 'conexao.php'; // Certifique-se de que o arquivo conexao.php está no mesmo diretório ou ajuste o caminho conforme necessário.

//var_dump($_SESSION);
if (!isset($_SESSION['usuario_id'])) {
  header('Location: login.php');
  exit;
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <title>Gerenciador de cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <?php include('navbar.php'); ?>
  <div class="container mt-4">
    <?php include('mensagem.php'); ?>
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="d-inline fw-bold fs-6"> Lista de Usuários
            <a title="Gerar Relatório em PDF" href="relatorio.php" target="_blank"
                class="btn btn-dark btn-sm mx-1 float-end">
                <span class="bi-filetype-pdf"></span> Relatório
              </a>
            </h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table  table-scroll table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data Nascimento</th>
                    <th>Tipo Usuário</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = 'SELECT * FROM usuarios';
                  $usuarios = mysqli_query($conexao, $sql);
                  if (mysqli_num_rows($usuarios) > 0) {
                    foreach ($usuarios as $usuario) {
                  ?>
                      <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><?= $usuario['nome'] ?></td>
                        <td><?= $usuario['email'] ?></td>
                        <td><?= date('d/m/Y', strtotime($usuario['data_nascimento'])) ?></td>
                        <td>
                          <?php
                          $sql_tipos_usuario = "SELECT tipo_usuario FROM tipos_usuario WHERE id = '$usuario[tipo_usuario_id]'";
                          $query_tipos_usuario = mysqli_query($conexao, $sql_tipos_usuario);
                          $tipo_usuario = mysqli_fetch_array($query_tipos_usuario);
                          echo $tipo_usuario['tipo_usuario'];
                          ?>
                        </td>
                      </tr>
                  <?php
                    }
                  } else {
                    echo '<h5>Nenhum usuário encontrado</h5>';
                  }
                  ?>
                </tbody>
              </table>
            </div>
            <td>
              <a href="usuario-view.php?id=<?= $usuario['id'] ?>"
                class="btn btn-secondary btn-sm mx-1 ms-auto"><span
                  class="bi-eye-fill"></span>&nbsp;Visualizar</a>
              <a href="usuario-edit.php?id=<?= $usuario['id'] ?>"
                class="btn btn-success btn-sm mx-1 ms-auto"><span class="bi-pencil-fill"></span>&nbsp;Editar</a>
              <form action="acoes.php" method="POST" class="d-inline">
                <button onclick="return confirm('Tem certeza que deseja excluir?')" type="submit"
                  name="delete_usuario" value="<?= $usuario['id'] ?>"
                  class="btn btn-danger btn-sm mx-1 ms-auto">
                  <span class="bi-trash3-fill"></span>&nbsp;Excluir
                </button>
              </form>
            </td>
            </td>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>