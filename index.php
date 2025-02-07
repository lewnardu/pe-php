<?php
session_start();
ob_start();
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Plantão Extra</title>

    <link rel="icon" type="image/png" sizes="16x16" href="imagens/favicon-16x16.png">

	<link href="css/bootstrap.css" rel="stylesheet">

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
          
	.pmodal{
                font-size: 18px;
                text-align: justify;
            }
            .pmodal-center {
                text-align: center;
                color: red;
                font-weight: bold;
            }
    </style>
     <link href="css/floating-labels.css" rel="stylesheet">
    
  </head>
  <body>
  <div class="container-fluid">
  <iframe id="barra-topo" src="https://barra.to.gov.br/topo.php?secad.to.gov.br" frameborder="no" scrolling="no" width="100%" height="150px"></iframe>
    <form class="form-signin" method="POST" action="valida.php">
     <div class="text-center mb-4">
     <img class="mb-4" src="imagens/logo-policia-penal.png" alt="" width="100" height="100">
     <h1 class="h3 mb-3 font-weight-normal"><b>PE</b> - PLANTÃO EXTRA</h1>
     <h5 class="h3 mb-3 font-weight-normal">ACESSO DO SERVIDOR</h5>
    </div>
    <?php
	if(isset($_SESSION['msg'])){
		echo $_SESSION['msg'];
		unset($_SESSION['msg']);
	}
    ?>

   <div class="form-label-group">
    <input type="text" class="form-control" placeholder="Usuario" required autofocus name="usuario" id="cpf">
    <label for="inputEmail">CPF</label>
  </div>

  <div class="form-label-group">
    <input type="password" class="form-control" placeholder="Senha" required name="senha">
    <label for="inputPassword">SENHA</label>
  </div>

   <div class="form-label-group">
     <div class="input-group">
       <div class="input-group-prepend">
       <span class="input-group-text"><img src="captcha.php" alt="captcha"></span>
     </div>
    <input type="text" class="form-control" maxlength="8" required name="captcha">
   </div>
  </div> 
  
  <button class="btn btn-lg btn-dark btn-block" type="submit">Entrar</button><br>
 
  <div class="alert alert-warning" role="alert">
    <a class="alert-link" href="primeiro.php">Primeiro acesso ou Resetar senha</a>
  </div>
   <p class="mt-5 mb-3 text-muted text-center">Setor de Gestão Tecnológica - SGT &copy; 2020-2024</p>
</form>
</div>
<!-- html do modal -->
            <div class="modal fade" style="background-color:yellow" id="avisomodal" tabindex="-1" role="dialog" aria-labelledby="modalrestricao" aria-hidden="true" data-backdrop="static">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title pmodal pmodal-center" id="modalrestricao">Aviso Importante!</h5>
                    </div>
                  <div class="modal-body">
                    <p class="pmodal pmodal-center">ATENÇÃO</p>
                    <p id="pmodal-aviso" class="pmodal">Recomendamos fortemente o uso do Sistema do Plantão Extraordinário por meio de computadores. Uma versão para dispositivos móveis será disponibilizada em breve. O uso do referido sistema em dispositivos móveis pode apresentar inconsistências, as quais podem prejudicar seu efetivo agendamento de plantão extra. Assista ao vídeo de direcionamento do sistema e, em caso de falhas, entre em contato com o Setor de Gestão Tecnológica - SGT pelo telefone/WhatsApp (63) 3218-1935.</p>
                  </div>
                  <div class="modal-footer">
                        <button id="pmodal" type="button" class="btn btn-success" data-dismiss="modal">Estou ciente</button>
                  </div>
                </div>
              </div>
            </div>

<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery.mask.js"></script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<script>
$(document).ready(function(){
   $('#cpf').mask('000.000.000-00', {reverse: true});
 });
 function maiuscula(z){
        v = z.value.toUpperCase();
        z.value = v;
    }
</script>
<script>
	$('#avisomodal').modal('show');
</script>

</body>
</html>

