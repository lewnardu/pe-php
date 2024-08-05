<?php

	$servidor = "localhost";
	$usuario = "root";
	$senha = "24J#h5@QFU%V";
	$bd = "externo";
	
	//Criar a conexao
	$conexao = mysqli_connect($servidor, $usuario, $senha, $bd);
	
	//Criar a conexao para eventos de plantao extra
	$db = "plantaoextra";
	$conexao2 = mysqli_connect($servidor, $usuario, $senha, $db);
?>
