<?php
session_start();
require 'conexao.php';
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Atendimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Editar Atendimento
                <a href="atendimento-view.php" class="btn btn-dark float-end">Voltar</a>
              </h4>
            </div>
            <div class="card-body">
              <?php
              if (isset($_GET['id'])) {
                  $atendimento_id = mysqli_real_escape_string($conexao, $_GET['id']);
                  $sql = "SELECT * FROM abertura_chamado WHERE id = '$atendimento_id'";
                  $query = mysqli_query($conexao, $sql);

                  if (mysqli_num_rows($query) > 0) {
                      $atendimento = mysqli_fetch_array($query);
              ?>
              <form action="acoes.php" method="POST">
                <input type="hidden" name="atendimento_id" value="<?= $atendimento['id'] ?>">

                <div class="mb-3">
                  <label>Sistema</label>
                  <input type="text" name="sistema" value="<?= $atendimento['sistema'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label>Descrição</label>
                  <textarea name="descricao" class="form-control" required><?= $atendimento['descricao'] ?></textarea>
                </div>

                <div class="mb-3">
                  <label>Solicitação</label>
                  <textarea name="solicitacao" class="form-control" required><?= $atendimento['solicitacao'] ?></textarea>
                </div>

                <div class="mb-3">
                  <label>Caminho da Ocorrência</label>
                  <input type="text" name="caminho_ocorrencia" value="<?= $atendimento['caminho_ocorrencia'] ?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Solicitante</label>
                  <input type="text" name="solicitante" value="<?= $atendimento['solicitante'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label>Email</label>
                  <input type="email" name="email" value="<?= $atendimento['email'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label>Data de Abertura</label>
                  <input type="date" name="data_abertura" value="<?= $atendimento['data_abertura'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label>Recorrente</label>
                  <select name="recorrente" class="form-control" required>
                    <option value="1" <?= $atendimento['recorrente'] == '1' ? 'selected' : '' ?>>Sim</option>
                    <option value="0" <?= $atendimento['recorrente'] == '0' ? 'selected' : '' ?>>Não</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label>Tipo de Usuário</label>
                  <input type="text" name="tipo_usuario_id" value="<?= $atendimento['tipo_usuario_id'] ?>" class="form-control" required>
                </div>

                <div class="mb-3">
                  <button type="submit" name="update_atendimento" class="btn btn-dark">Salvar</button>
                </div>
              </form>
              <?php
                  } else {
                      echo "<h5>Atendimento não encontrado</h5>";
                  }
              } else {
                  echo "<h5>ID do Atendimento não fornecido</h5>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
