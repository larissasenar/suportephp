<?php
require_once __DIR__ . '\bibliotecas\dompdf\autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar o Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$dompdf = new Dompdf($options);

// Logo e estilo CSS
$logo = 'path/to/logo.png'; // Insira o caminho da sua logo
$html = '
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }
    .logo {
        text-align: center;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    h1 {
        text-align: center;
        color: #333;
    }
</style>
';

// Adicionar logo e cabeçalho
$html .= '
<div class="logo">
    <img src="' . $logo . '" alt="Logo" width="150">
</div>
<h1>Relatório de Atendimentos</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Data de Nascimento</th>
            <th>Tipo de Usuário</th>
        </tr>
    </thead>
    <tbody>
';

// Conectar ao banco de dados e buscar os dados
require 'conexao.php';
$sql = 'SELECT usuarios.id, usuarios.nome, usuarios.email, usuarios.data_nascimento, tipos_usuario.tipo_usuario 
        FROM usuarios 
        JOIN tipos_usuario ON usuarios.tipo_usuario_id = tipos_usuario.id';
$resultado = mysqli_query($conexao, $sql);

if (mysqli_num_rows($resultado) > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $html .= '
        <tr>
            <td>' . $row['id'] . '</td>
            <td>' . htmlspecialchars($row['nome']) . '</td>
            <td>' . htmlspecialchars($row['email']) . '</td>
            <td>' . date('d/m/Y', strtotime($row['data_nascimento'])) . '</td>
            <td>' . htmlspecialchars($row['tipo_usuario']) . '</td>
        </tr>
        ';
    }
} else {
    $html .= '
    <tr>
        <td colspan="5" style="text-align:center;">Nenhum registro encontrado</td>
    </tr>
    ';
}

// Fechar tabela e conteúdo
$html .= '
    </tbody>
</table>
';

// Gerar o PDF
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landspace');
$dompdf->render();

// Enviar o PDF ao navegador
$dompdf->stream("relatorio_atendimentos.pdf", ["Attachment" => false]);
exit;
