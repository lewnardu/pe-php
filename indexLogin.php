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
    <link href="css/floating-labels.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-6 d-none d-md-block">
                    <img src="imagens/flyers/spex-unidade.jpg" class="card-img" alt="..." width="100%" height="100%">
                </div>
                <div class=" col-md-6">
                    <div class="card-body">
                        <form method="POST" action="registro/valida.php">
                            <div class="text-center">
                                <img src="imagens/logo-policia-penal.png" alt="" width="100" height="100">
                                <h1 class="h3 mb-3 font-weight-normal">Plantão Extraordinário</h1>
                                <h5 class="h6 mb-3 font-weight-nornal">Acesso do Servidor</h5>
                            </div>

                            <?php
                                if(isset($_SESSION['msg'])){
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>

                            <div class="row">
                                <div class="form-label-group col-12">
                                    <label for="cpf">Usuário:</label>
                                    <input type="text" class="form-control" placeholder="___.___.___-__" required
                                        autofocus name="usuario" id="cpf">

                                </div>

                                <div class="form-label-group col-12">
                                    <label for="senha">Senha:</label>
                                    <input type="password" class="form-control" placeholder="Digite a senha" required
                                        name="senha">

                                </div>

                                <div class="form-label-group col-12">
                                    <label for="senha">Captcha:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text p-0">
                                                <img src="captcha.php" alt="captcha" class="captcha-img">
                                            </span>
                                        </div>
                                        <input type="text" class="form-control" maxlength="8" required name="captcha"
                                            placeholder="Digite o captcha">
                                    </div>
                                </div>
                            </div>

                            <div class="bnt-group">
                                <button class="btn btn-dark w-100 mb-3" type="submit">Entrar</button>
                                <a class="btn btn-outline-warning w-100 text-dark" href="primeiro.php">Primeiro
                                    acesso? Clique
                                    aqui para criar ou redefinir sua senha.</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <p class="text-center text-muted">&copy; Setor de Gestão Tecnológica - SGT 2020-2024</p>
        </div>
    </footer>

    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00', {
            reverse: true
        });
    });

    function maiuscula(z) {
        v = z.value.toUpperCase();
        z.value = v;
    }
    </script>
</body>

</html>