<?php
session_start();
ob_start();
require_once('../Database.php');
$conexao = new Database('DB_NAME_EXT');

$acessar = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_STRING);

if($_SESSION['captcha'] == $acessar){
	$usuario = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
	if((!empty($usuario)) AND (!empty($senha))){
		$pesq_usuario = "SELECT * FROM usuarios WHERE cpf = :cpf LIMIT 1;";
        $resultado_usuario = $conexao->query($pesq_usuario, [':cpf' => $usuario]);
		if($resultado_usuario){
            $usr = $resultado_usuario[0];
			if(password_verify($senha, $usr['senha'])){
				$pesq = "SELECT * FROM aep WHERE cpf = :cpf LIMIT 1";
                $result = $conexao->query($pesq, [':cpf' => $usuario]);
                $aep = $result[0];
				foreach ($aep as $key => $value) {
					$_SESSION[$key] = $value;
				}
				$_SESSION['cpf'] = $usr['cpf'];
				$_SESSION['inicio'] = time(); 
                $_SESSION['expira'] = $_SESSION['inicio'] + (30 * 60);
				header("Location: ../index.php");	
                exit();
			}else{
				$_SESSION['msg'] = "<div class='alert alert-danger'>Acesso negado! Erro nas credenciais de acesso.</div>";
				header("Location: ../login.php");
                exit();
			}
		}else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhum usuário encontrado com o CPF informado!</div>";
			header("Location: ../login.php");
            exit();
        }
	}else{
		$_SESSION['msg'] = "<div class='alert alert-danger'>Informe as credenciais de acesso!</div>";
		header("Location: ../login.php");
        exit();
	}
}else{
	$_SESSION['msg'] = "<div class='alert alert-danger'>O captcha informado é inválido!</div>";
    header("Location: ../login.php");
    exit();
}
?>