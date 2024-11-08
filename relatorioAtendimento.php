<?php
require_once __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

// Logo e estilo CSS
$html = '
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 10px 10px 10px 10px;
        font-size: 12px;
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
        padding: 5px;
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
     <h1>Comunicaê Digital</h1>
</div>
<h1>Relatório de Atendimentos</h1>
<table>
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
';

// Conectar ao banco de dados e buscar os dados
require 'conexao.php';
$sql = "SELECT 
  abertura_chamado.id,
  abertura_chamado.sistema,
  abertura_chamado.descricao,
  abertura_chamado.solicitacao,
  abertura_chamado.caminho_ocorrencia,
  abertura_chamado.solicitante,
  abertura_chamado.email,
  abertura_chamado.data_abertura,
  abertura_chamado.recorrente,
  tipos_usuario.tipo_usuario
FROM 
  abertura_chamado 
  JOIN tipos_usuario ON abertura_chamado.tipo_usuario_id = tipos_usuario.id";

$resultado = mysqli_query($conexao, $sql);

if (mysqli_num_rows($resultado) > 0) {
  while ($row = mysqli_fetch_assoc($resultado)) {
    $html .= ' 
      <tr> 
        <td>' . $row['id'] . '</td> 
        <td>' . htmlspecialchars($row['sistema']) . '</td> 
        <td>' . htmlspecialchars($row['descricao']) . '</td> 
        <td>' . htmlspecialchars($row['solicitacao']) . '</td> 
        <td>' . htmlspecialchars($row['caminho_ocorrencia']) . '</td> 
        <td>' . nl2br(htmlspecialchars($row['solicitante'])) . '</td>
        <td>' . htmlspecialchars($row['email']) . '</td> 
        <td>' . date('d/m/Y', strtotime($row['data_abertura'])) . '</td> 
        <td>' . htmlspecialchars($row['recorrente']) . '</td> 
        <td>' . htmlspecialchars($row['tipo_usuario']) . '</td> 
      </tr> 
    ';
  }
} else {
    $html .= '
    <tr>
        <td colspan="7" style="text-align:center;">Nenhum registro encontrado</td>
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
$dompdf->setPaper('A4', 'Landscape');
$dompdf->render();
// Enviar o PDF ao navegador
$dompdf->stream("relatorio_atendimentos.pdf", ["Attachment" => false]);
exit;
