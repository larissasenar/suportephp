<?php
define('HOST', '127.0.0.1');
define('USUARIO', 'root');
define('SENHA', '');
define('DB', 'comunicaedigital');
 
$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('Falha na conexão com o banco de dados:');

?>