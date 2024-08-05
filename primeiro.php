<?php
session_start();
ob_start();
$cadastrar = filter_input(INPUT_POST, 'cadastrar', FILTER_SANITIZE_STRING);
if($cadastrar){

	include_once 'conexao.php';
	$dadosS = filter_input_array(INPUT_POST, FILTER_DEFAULT);
	
	$dadosT = array_map('strip_tags', $dadosS);	//retirando as tag
	$dados = array_map('trim', $dadosT);	//retirando os espaços
	
	if(in_array('',$dados)){
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger'>Necessário preencher todos os campos!</div>";
	}elseif($dados['captcha'] != $_SESSION['captcha']){
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger'>Captcha incorreto!</div>";
	}elseif((strlen($dados['senha'])) < 8){
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve ter no minímo 8 caracteres!</div>";
	}elseif(stristr($dados['senha'], "'")) {
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger'>Caracter ( ' ) utilizado na senha é inválido!</div>";
	}elseif($dados['senha'] != $dados['rsenha']){
		$erro = true;
		$_SESSION['msg'] = "<div class='alert alert-danger'>Senhas incompatíveis!</div>";
	}else{
		
		
		$pesq_usuario = "SELECT cpf FROM usuarios WHERE cpf='". $dados['cpf'] ."' LIMIT 1";
		$result = mysqli_query($conexao, $pesq_usuario);
		
		if(($result) AND ($result->num_rows == 0)){
			$erro = true;
			$_SESSION['msg'] = "<div class='alert alert-danger'>CPF não cadastrado!</div>";
		
		}else{
			$query= "SELECT * FROM usuarios WHERE cpf='".$dados['cpf']."' LIMIT 1";
			$res= mysqli_query($conexao, $query);
			$res= mysqli_fetch_array($res);
			
			$pesq_usuario = "SELECT * FROM aep WHERE cpf='".$dados['cpf']."' LIMIT 1";
			$result = mysqli_query($conexao, $pesq_usuario);
			$us= mysqli_fetch_array($result);
		
	/*	if($res['senha'] != '?'){
			        $erro = true;
				$_SESSION['msg'] = "<div class='alert alert-warning'>Senha já cadastrada procure a ESGEPEN</div>";
			} */
			if($us['nome'] != $dados['nome']){
				$erro = true;
				$_SESSION['msg'] = "<div class='alert alert-danger'>Erro no nome!</div>";
			}
			if($us['funcional'] != $dados['matricula']){
				$erro = true;
				$_SESSION['msg'] = "<div class='alert alert-danger'>Erro na matricula!</div>";
			}
			
			$fone = preg_replace('/[^0-9]/', '', $dados['fone']);
			if($us['fone'] != $fone){
				$erro = true;
				$_SESSION['msg'] = "<div class='alert alert-danger'>Telefone não cadastrado!</div>";
			}
			if($us['e-mail'] != $dados['e-mail']){
				$erro = true;
				$_SESSION['msg'] = "<div class='alert alert-danger'>E-mail não cadastrado!</div>";
			}
			if($us['dtnasc'] != $dados['dtnasc']){
				$erro = true;
				$_SESSION['msg'] = "<div class='alert alert-danger'>Data Nascimento divergente!</div>";
			}
					
		} 
	}
	
	if(!$erro){
		
		$dados['senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
		
		$query = "UPDATE usuarios set senha='".$dados['senha']."' WHERE cpf='".$dados['cpf']."'";
		$result_usario = mysqli_query($conexao, $query);
		
		if(mysqli_affected_rows($conexao)){
			$_SESSION['msg'] = "<div class='alert alert-success'>Senha cadastrada com sucesso!</div>";
			//header("Location: index.php");
		}else{
			$_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao cadastrar senha!</div>";
		}
	}
}
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Extra</title>

	<link href="css/bootstrap.min.css" rel="stylesheet">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    
    <link href="css/floating-labels.css" rel="stylesheet">
  </head>
  <body>
   
    <form class="form-signin" method="POST" action="">
  <div class="text-center mb-4">
    <img class="mb-4" src="imagens/logo-policia-penal.png" alt="" width="100" height="100">
    <h1 class="h3 mb-3 font-weight-normal">Primeiro Acesso</h1>
  </div>
  <?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
  ?>
  <div class="form-label-group">
    <input type="text" class="form-control" placeholder="NOME" required autofocus name="nome" id="nome" onkeyup="maiuscula(this)">
    <label for="inputEmail">NOME</label>
  </div>
  
   <div class="form-label-group">
    <input type="text" class="form-control" placeholder="MATRICULA (sem dígito verificador)" required autofocus name="matricula" id="mat">
    <label for="inputEmail">MATRICULA (sem dígito verificador)</label>
   </div>
    
   <div class="form-label-group">
    <input type="text" class="form-control" placeholder="CPF" required autofocus name="cpf" id="cpf">
    <label for="inputEmail">CPF</label>
   </div> 
   
   <div class="form-label-group">
    <input type="text" class="form-control" placeholder="TELEFONE" required autofocus name="fone" id="cel">
    <label for="inputEmail">TELEFONE</label>
   </div> 
   
   <div class="form-label-group">
    <input type="email" class="form-control" placeholder="E-MAIL" required autofocus name="e-mail">
    <label for="inputEmail">E-MAIL</label>
   </div> 
   
   <div class="form-label-group">
    <input type="text" class="form-control" placeholder="DATA DE NASCIMENTO" required autofocus name="dtnasc" id="data">
    <label for="inputEmail">DATA DE NASCIMENTO</label>
   </div> 
      <div class="form-label-group">
    <input type="password" class="form-control" placeholder="SENHA(mínino 8 caracteres)" required autofocus name="senha">
    <label for="inputEmail">SENHA (mínino 8 caracteres)</label>
   </div>
      <div class="form-label-group">
    <input type="password" class="form-control" placeholder="REPITA A SENHA" required autofocus name="rsenha">
    <label for="inputEmail">REPITA A SENHA</label>
   </div>
   
   <div class="form-label-group">
     <div class="input-group">
       <div class="input-group-prepend">
       <span class="input-group-text"><img src="captcha.php" alt="captcha"></span>
     </div>
    <input type="text" class="form-control" maxlength="8" required name="captcha">
   </div>
  </div>
       
<!--           <button class="btn btn-lg btn-dark btn-block" value="false" name="#" type="#">Salvar</button><br> --> 
       <button class="btn btn-lg btn-dark btn-block" value="true" name="cadastrar" type="submit">Salvar</button><br> 
  
  <div class="alert alert-primary" role="alert">
    <a class="alert-link" href="index.php">Retornar</a>
  </div>
  
  <p class="mt-5 mb-3 text-muted text-center">SGT/SISPEN &copy;2020-2022</p>
 </form>
<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.mask.js"></script>
<script>
$(document).ready(function(){
  $('#cel').mask('(00) 00000-0000');
  $('#mat').mask('00000000');
  $('#data').mask('00/00/0000');
  $('#cpf').mask('000.000.000-00', {reverse: true});
 });
 function maiuscula(z){
        v = z.value.toUpperCase();
        z.value = v;
    }
</script>
</body>
</html>

