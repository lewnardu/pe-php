<?php
session_start();
if(!empty($_SESSION['cpf'])){

header("Location: ../home.php");

}else{
	$_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
	header("Location: ../index.php");
} 
?>