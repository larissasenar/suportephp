<?php
session_start();
require 'conexao.php'; // Certifique-se de que o arquivo conexao.php está no mesmo diretório ou ajuste o caminho conforme necessário.

date_default_timezone_set('America/Sao_Paulo');

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
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/teste.css">
</head>

<body>
    <?php include('navbar.php'); ?>

    <div class="container-fluid mt-4">
        <?php
        $hora = date('H');
        $saudacao = ($hora < 12) ? 'Bom dia' : (($hora < 18) ? 'Boa tarde' : 'Boa noite');
        ?>
        <header class="text-center mb-4">
            <h1>Gerenciador de Atendimentos</h1>
            <p><?= $saudacao; ?>, <strong><?= $_SESSION['usuario_nome']; ?></strong>!</p>
        </header>
        <!-- Cards -->
        <div class="row">
            <div class="col-md-3">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-person-plus-fill"></i> Cadastro de Usuário</h5>
                        <p>Adicione e configure usuários com permissões específicas.</p>
                        <a href="usuario.php" class="btn btn-dark">Usuário</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-plus-circle-fill"></i> Abertura de Chamado</h5>
                        <p>Registre chamados e gerencie seus status de forma eficiente.</p>
                        <a href="atendimento.php" class="btn btn-dark">Abrir Chamado</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-file-earmark-text-fill"></i> Relatórios</h5>
                        <p>Gere relatórios detalhados de usuários e atendimentos.</p>
                        <div class="d-flex justify-content-around">
                            <a title="Gerar Relatório em PDF" href="relatorioUsuario.php" target="_blank" class="btn btn-dark">
                                <span class="bi-filetype-pdf"></span> Relatório Usuário
                            </a>
                            <a title="Gerar Relatório em PDF" href="relatorioAtendimento.php" target="_blank" class="btn btn-dark">
                                <span class="bi-filetype-pdf"></span> Relatório Atendimento
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 shadow">
                    <div class="card-body text-center">
                        <h5 class="card-title"><i class="bi bi-bar-chart-fill"></i> Chamados em Andamento</h5>
                        <p>Atualmente há chamado(s) em andamento.</p>
                        <a href="#" class="btn btn-dark">Ver Detalhes</a>
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
