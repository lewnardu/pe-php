<?php

session_start();
unset($_SESSION['nome'], $_SESSION['cpf'], $_SESSION['unidade'], $_SESSION['e-mail'], $_SESSION['preferencia'],	$_SESSION['fone'], $_SESSION['funcional']); 				

$_SESSION['msg'] = "<div class='alert alert-success'>Deslogado com sucesso!</div>";
header("Location: index.php");
