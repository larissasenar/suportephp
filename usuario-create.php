<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuário - Criar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Adicionar usuário
                            <a href="usuario.php" class="btn btn-dark float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="acoes.php" method="POST">
                            <div class="mb-3">
                                <label>Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>
                            <!-- TODO data de abertura-->
                            <div class="mb-3">
                                <label>Data de Nascimento</label>
                                <input type="date" name="data_nascimento" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_usuario">Tipo de Usuário</label>
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
                                <button type="submit" name="create_atendimento" class="btn btn-dark">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>