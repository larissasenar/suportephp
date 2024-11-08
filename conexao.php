<?php
define('HOST', 'sql208.infinityfree.com');
define('USUARIO', 'if0_37658770');
define('SENHA', 'n58CWn9X08fgRp');
define('DB', 'if0_37658770_comunicaedigital');
 
$conexao = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ('Não foi possível conectar');
?>