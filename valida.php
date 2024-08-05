<?php
session_start();
require_once('conexao.php');
$acessar = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_STRING);

if($_SESSION['captcha'] == $acessar){

	$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	
	if((!empty($usuario)) AND (!empty($senha))){

		$pesq_usuario = "SELECT * FROM usuarios WHERE cpf='$usuario' LIMIT 1;";
		$resultado_usuario = mysqli_query($conexao, $pesq_usuario);
		if($resultado_usuario){
			$usr = mysqli_fetch_assoc($resultado_usuario);
			if(password_verify($senha, $usr['senha'])){
				
				$pesq = "SELECT * FROM aep where cpf='".$usuario."' LIMIT 1";
				$result= mysqli_query($conexao,$pesq);
				$aep = mysqli_fetch_assoc($result);

				$_SESSION['nome'] = $aep['nome'];
				$_SESSION['cpf'] = $usr['cpf'];
				$_SESSION['unidade'] = $aep['lotação'];
				$_SESSION['e-mail'] = $aep['e-mail'];
				$_SESSION['preferencia'] = $aep['preferencia'];
				$_SESSION['fone'] = $aep['fone'];
				$_SESSION['funcional'] = $aep['funcional'];
				$_SESSION['número'] = $aep['numero'];
				$_SESSION['media'] = $aep['numero'];
				$_SESSION['extra'] = $aep['extra'];
				$_SESSION['restrição'] = $aep['restrição'];
				
				$_SESSION['inicio'] = time(); 
           			$_SESSION['expira'] = $_SESSION['inicio'] + (30 * 60);

				if($aep['preferencia'] == 'UNIDADE PENAL DE PALMAS' || $aep['preferencia'] == 'UNIDADE DE TRATAMENTO PENAL BARRA DA GROTA' || $aep['preferencia'] == 'UNIDADE DE SEGURANÇA MÁXIMA DE CARIRI'){
				//	unset($_SESSION);//
				//	session_destroy();//
					header("Location: home.php");
				//	header("Location: https://sites.google.com/goodteak.com/sgt-manutencao/spex2");//
		
				}else{
				//	unset($_SESSION);
				//	session_destroy();
				//	header("Location: https://sites.google.com/goodteak.com/sgt-manutencao/spex2");
					header("Location: home.php");//
					}
			}else{
				$_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto! ESGEPEN pelo telefone/WhatsApp (63) 3218-6721</div>";
				header("Location: index.php");
			}
		}
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger'>Login ou senha incorreto! SGT pelo telefone/WhatsApp (63) 3218-1935</div>";
		header("Location: index.php");
	}
}else{
	$_SESSION['msg'] = "<div class='alert alert-danger'>Erro no captcha!</div>";
		header("Location: index.php");
}

?>
