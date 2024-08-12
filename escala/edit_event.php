<?php
session_start();
if(!empty($_SESSION['cpf'])){

	 include_once("conexao.php");


	  $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
	  $nome = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);

	     if($_SESSION['restrição'] == '' && $_SESSION['extra'] === 'true' ){

		         if(!empty($id) && !empty($nome)){
                 
                 # verificar no banco atravez do id, se a vaga esta livre e condicionar o Update
                 $sql = "SELECT nome FROM demanda WHERE id='$id'";
                 $re = mysqli_query($conexao, $sql);
                 $res =  mysqli_fetch_array($re);
                 
                 
                 if($res['nome'] == 'livre'){
                 	 $result = "UPDATE demanda SET nome='$nome' WHERE id='$id'"; 
					$resultado = mysqli_query($conexao, $result); 
                 
                 	if(mysqli_affected_rows($conexao)){
					$retorna = ['sit' => true, 'msg' => '<div class="alert alert-danger" role="alert"></div>'];
						    
					$_SESSION['msg'] = '<div class="alert alert-success" role="alert">cadastrado!</div>';

					}else{
						$retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Ops!: Extra não disponivel mais!</div>'];
                		$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Ops: Alguem escolheu essa vaga antes de você!</div>';
                    	header('Refresh:0');
					} 
                 
                 }else{
                 	$retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Ops: Alguem escolheu essa vaga antes de você!</div>'];
                 	$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Ops: Alguem escolheu essa vaga antes de você!</div>';
                 }
						
		}
		header('Content-Type: application/json');
		echo json_encode($retorna);

	    }else{
	    	$retorna = ['sit' => false, 'msg' => '<div class="alert alert-danger" role="alert">Erro: Não cadastrado, usuário possui restrição!</div>'];
	    }

}else{
	$_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
	header("Location: ../index.php");
}
?>