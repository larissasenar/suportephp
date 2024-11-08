<?php
session_start();
require 'conexao.php'; // Conexão com o banco

if (!isset($_GET['id'])) {
    $_SESSION['mensagem'] = "ID do chamado não informado.";
    header("Location: atendimento.php");
    exit;
}

$id = mysqli_real_escape_string($conexao, $_GET['id']);

// Consulta para obter os detalhes do chamado
$sql = "SELECT ac.*, tu.tipo_usuario 
        FROM abertura_chamado ac 
        INNER JOIN tipos_usuario tu ON ac.tipo_usuario_id = tu.id
        WHERE ac.id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    $_SESSION['mensagem'] = "Chamado não encontrado.";
    header("Location: atendimento.php");
    exit;
}

$chamado = $resultado->fetch_assoc();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Visualizar Atendimento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Detalhes do Atendimento
                            <a href="atendimento.php" class="btn btn-dark btn-sm float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label"><strong>ID:</strong></label>
                            <p class="form-control"><?= $chamado['id'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Sistema:</strong></label>
                            <p class="form-control"><?= $chamado['sistema'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Descrição:</strong></label>
                            <p class="form-control"><?= $chamado['descricao'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Solicitação:</strong></label>
                            <p class="form-control"><?= $chamado['solicitacao'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label>Anexo:</label>
                            <a href="<?= $chamado['anexo']; ?>" target="_blank"><?= $chamado['anexo']; ?></a>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Caminho da Ocorrência:</strong></label>
                            <p class="form-control"><?= $chamado['caminho_ocorrencia'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Solicitante:</strong></label>
                            <p class="form-control"><?= $chamado['solicitante'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Email:</strong></label>
                            <p class="form-control"><?= $chamado['email'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Data de Abertura:</strong></label>
                            <p class="form-control"><?= date('d/m/Y', strtotime($chamado['data_abertura'])) ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Recorrente:</strong></label>
                            <p class="form-control"><?= $chamado['recorrente'] ?></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Tipo de Usuário:</strong></label>
                            <p class="form-control"><?= $chamado['tipo_usuario'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>