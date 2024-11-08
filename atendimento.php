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
<html lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="mobile-web-app-capable" content="yes">
  <title>Gerenciador de atendimentos</title>
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
            <h4 class="d-inline fw-bold fs-6">Lista de Atendimentos</h4>
            <div class="float-end">
              <!-- Ação de criar atendimento -->
              <a href="create_atendimento.php" class="btn btn-dark btn-sm me-2">
                <i class="bi bi-plus"></i>&nbsp;Novo Atendimento
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-scroll table-bordered table-striped table-condensed">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Sistema</th>
                    <th>Descrição</th>
                    <th>Solicitação</th>
                    <th>Caminho Ocorrência</th>
                    <th>Solicitante</th>
                    <th>Email</th>
                    <th>Data Abertura</th>
                    <th>Recorrente</th>
                    <th>Tipo Usuário</th>
                  </tr>
                </thead>

                <tbody>
                  <?php
                  $sql = 'SELECT ac.*, tu.tipo_usuario 
          FROM abertura_chamado ac 
          INNER JOIN tipos_usuario tu ON ac.tipo_usuario_id = tu.id';

                  $stmt = $conexao->prepare($sql);
                  $stmt->execute();
                  $resultado = $stmt->get_result();

                  if ($resultado->num_rows > 0) {
                    while ($chamado = $resultado->fetch_assoc()) {
                  ?>
                      <tr>
                        <td><?= $chamado['id'] ?></td>
                        <td><?= $chamado['sistema'] ?></td>
                        <td><?= $chamado['descricao'] ?></td>
                        <td><?= $chamado['solicitacao'] ?></td>
                        <td><?= $chamado['caminho_ocorrencia'] ?></td>
                        <td><?= $chamado['solicitante'] ?></td>
                        <td><?= $chamado['email'] ?></td>
                        <td><?= date('d/m/Y', strtotime($chamado['data_abertura'])) ?></td>
                        <td><?= $chamado['recorrente'] ?></td>
                        <td><?= $chamado['tipo_usuario'] ?></td>
                        <td>
                          <!-- Botão de Visualizar -->
                          <a href="atendimento-view.php?id=<?= $chamado['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-eye-fill"></i> Visualizar
                          </a>
                        </td>
                        <td>
                          <!-- Botão de Visualizar -->
                          <a href="atendimento-edit.php?id=<?= $chamado['id'] ?>" class="btn btn-success btn-sm mx-1 ms-auto">
                            <i class="bi bi-eye-fill"></i> Editar
                          </a>
                        </td>
                        <td>
                          <form action="acoes.php" method="POST" class="d-inline">
                            <input type="hidden" name="atendimento_id" value="<?= $chamado['id'] ?>">
                            <button type="submit" name="delete_atendimento" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este atendimento?')">
                              <i class="bi bi-trash3-fill"></i> Excluir
                            </button>
                          </form>
                        </td>

                      </tr>
                  <?php
                    }
                  } else {
                    echo '<tr><td colspan="11" class="text-center">Nenhum chamado encontrado</td></tr>';
                  }
                  ?>
                </tbody>

              </table>
            </div>
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