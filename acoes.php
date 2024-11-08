<?php
session_start();
require 'conexao.php';

if (isset($_POST['create_usuario'])) {
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $tipo_usuario_id = mysqli_real_escape_string($conexao, trim($_POST['tipo_usuario']));  // Corrigido para 'tipo_usuario'
    $senha = isset($_POST['senha']) ? mysqli_real_escape_string($conexao, password_hash(trim($_POST['senha']), PASSWORD_DEFAULT)) : '';

    $sql = "INSERT INTO usuarios (nome, email, data_nascimento, tipo_usuario_id, senha) VALUES ('$nome', '$email', '$data_nascimento', '$tipo_usuario_id', '$senha')";

    // Verifica se algum campo está vazio
    if (empty($nome) || empty($email) || empty($data_nascimento) || empty($tipo_usuario_id) || empty($senha)) {
        $_SESSION['mensagem'] = 'Por favor, preencha todos os campos.';
        header('Location: usuario-create.php');
        exit;
    }

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = 'Usuário criado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Erro: ' . mysqli_error($conexao);
        header('Location: index.php');
        exit;
    }
}



if (isset($_POST['update_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['usuario_id']);
    $nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));
    $email = mysqli_real_escape_string($conexao, trim($_POST['email']));
    $data_nascimento = mysqli_real_escape_string($conexao, trim($_POST['data_nascimento']));
    $tipo_usuario_id = mysqli_real_escape_string($conexao, trim($_POST['tipo_usuario']));
    $senha = mysqli_real_escape_string($conexao, trim($_POST['senha']));

    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email', data_nascimento = '$data_nascimento', tipo_usuario_id = '$tipo_usuario_id'";

    if (!empty($senha)) {
        $sql .= ", senha='" . password_hash($senha, PASSWORD_DEFAULT) . "'";
    }
    $sql .= " WHERE id = '$usuario_id'";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = 'Usuário atualizado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Erro: ' . mysqli_error($conexao);
        header('Location: index.php');
        exit;
    }
}

if (isset($_POST['delete_usuario'])) {
    $usuario_id = mysqli_real_escape_string($conexao, $_POST['delete_usuario']);
    $sql = "DELETE FROM usuarios WHERE id = '$usuario_id'";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = 'Usuário deletado com sucesso';
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['mensagem'] = 'Erro: ' . mysqli_error($conexao);
        header('Location: index.php');
        exit;
    }
}


//atendimento 
if (isset($_POST['create_atendimento'])) {
    $sistema = $_POST['sistema'];
    $descricao = $_POST['descricao'];
    $solicitacao = $_POST['solicitacao'];
    $caminho_ocorrencia = $_POST['caminho_ocorrencia'];
    $solicitante = $_POST['solicitante'];
    $email = $_POST['email'];
    $data_abertura = $_POST['data_abertura'];
    $recorrente = $_POST['recorrente'];
    $tipo_usuario_id = mysqli_real_escape_string($conexao, trim($_POST['tipo_usuario']));

    $sql = "INSERT INTO abertura_chamado (sistema, descricao, solicitacao, caminho_ocorrencia, solicitante, email, data_abertura, recorrente, tipo_usuario_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("sssssssss", $sistema, $descricao, $solicitacao, $caminho_ocorrencia, $solicitante, $email, $data_abertura, $recorrente, $tipo_usuario_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Atendimento cadastrado com sucesso!";
        header("Location: atendimento.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Erro ao salvar o atendimento: " . $conexao->error;
        header("Location: create_atendimento.php");
        exit();
    }
}



//update atencimento 

if (isset($_POST['update_atendimento'])) {
    $id = mysqli_real_escape_string($conexao, $_POST['id']);
    $sistema = mysqli_real_escape_string($conexao, $_POST['sistema']);
    $descricao = mysqli_real_escape_string($conexao, $_POST['descricao']);
    $solicitacao = mysqli_real_escape_string($conexao, $_POST['solicitacao']);
    $caminho_ocorrencia = mysqli_real_escape_string($conexao, $_POST['caminho_ocorrencia']);
    $solicitante = mysqli_real_escape_string($conexao, $_POST['solicitante']);
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $data_abertura = mysqli_real_escape_string($conexao, $_POST['data_abertura']);
    $recorrente = mysqli_real_escape_string($conexao, $_POST['recorrente']);
    $tipo_usuario_id = mysqli_real_escape_string($conexao, $_POST['tipo_usuario_id']);

    $sql = "UPDATE abertura_chamado 
            SET sistema = '$sistema', descricao = '$descricao', solicitacao = '$solicitacao',
                caminho_ocorrencia = '$caminho_ocorrencia', solicitante = '$solicitante', email = '$email',
                data_abertura = '$data_abertura', recorrente = '$recorrente', tipo_usuario_id = '$tipo_usuario_id'
            WHERE id = '$id'";

    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Atendimento atualizado com sucesso.";
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar atendimento.";
        header('Location: atendimento-edit.php?id=' . $id);
        exit();
    }
}

//delete atendimento

if (isset($_POST['delete_atendimento'])) {
    $id = mysqli_real_escape_string($conexao, $_POST['atendimento_id']);

    $sql = "DELETE FROM abertura_chamado WHERE id = '$id'";
    if (mysqli_query($conexao, $sql)) {
        $_SESSION['mensagem'] = "Atendimento excluído com sucesso.";
        header('Location: index.php'); // Redireciona para a lista de atendimentos
        exit();
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir atendimento.";
        header('Location: index.php');
        exit();
    }
}
