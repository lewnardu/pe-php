<?php
session_start();
if(!empty($_SESSION['cpf'])){

	include_once("conexao.php");

	$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

	if (!empty($id)) {
		     

			$query= "update demanda set nome='livre' where id=".$id;
				$apagar = mysqli_query($conexao, $query);
				

			   if($apagar){
				           $_SESSION['msg'] = '<div class="alert alert-success" role="alert">Deletado com sucesso!</div>';
					           header("Location: extra.php");
					           
					    	
					       }else{
						               $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Não foi apagado!</div>';
							               header("Location: extra.php");
							           }
	} else {
		    $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Não foi apagado!</div>';
		        header("Location: extra.php");
	}
}else{
		$_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
			header("Location: ../index.php");
}
?>
