<?php
session_start();
ob_start();
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Extra</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/floating-labels.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="row no-gutters">
                <div class="col-md-6 d-none d-md-block">
                    <img src="imagens/flyers/spex-coletes.jpeg" class="card-img" alt="..." width="100%" height="100%">
                </div>
                <div class="col-md-6">
                    <div class="card-body overflow-auto" style="max-height: 600px;">
                        <form method="POST" action="registro/primeiro.php">
                            <div class="text-center">
                                <img src="imagens/logo-policia-penal.png" alt="" width="100" height="100">
                                <h1 class="h3 mb-3 font-weight-normal">Plantão Extraordinário</h1>
                                <h5 class="h6 mb-3 font-weight-nornal">Primeiro Acesso</h5>
                            </div>

                            <?php
                                if(isset($_SESSION['msg'])){
                                    echo $_SESSION['msg'];
                                    unset($_SESSION['msg']);
                                }
                            ?>

                            <div class="row">
                                <div class="form-label-group col-12">
                                    <label for="nome">Nome:</label>
                                    <input type="text" class="form-control" placeholder="Digite o nome completo"
                                        required autofocus name="nome" id="nome" onkeyup="maiuscula(this)">
                                </div>

                                <div class="form-label-group col-12">
                                    <label for="matricula">Matrícula:</label>
                                    <input type="text" class="form-control"
                                        placeholder="Digite a matrícula sem o vínculo" required name="matricula"
                                        id="matricula">
                                </div>

                                <div class="form-label-group col-12">
                                    <label for="cpf">CPF:</label>
                                    <input type="text" class="form-control" placeholder="___.___.___-__" required
                                        name="cpf" id="cpf">
                                </div>

                                <div class="form-label-group col-12">
                                    <label for="fone">Telefone:</label>
                                    <input type="text" class="form-control" placeholder="(00) 00000-0000" required
                                        name="fone" id="fone">
                                </div>

                                <div class="form-label-group col-12">
                                    <label for="email">E-mail:</label>
                                    <input type="text" class="form-control" placeholder="Digite o e-mail" required
                                        name="email">
                                </div>


                                <div class="form-label-group col-12">
                                    <label for="email">Data de Nascimento:</label>
                                    <input type="text" class="form-control" placeholder="__/__/____" required autofocus
                                        name="dtnasc" id="data">
                                </div>

                                <div class="form-label-group col-12">
                                    <label for="senha">Nova Senha:</label>
                                    <input type="password" class="form-control" placeholder="Digite a nova senha"
                                        required name="senha">
                                </div>

                                <div class="form-label-group col-12">
                                    <label for="senha">Confirmar Senha:</label>
                                    <input type="password" class="form-control" placeholder="Confirme a nova senha"
                                        required name="rsenha">

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
                                <button class="btn btn-dark w-100 mb-3" type="submit">Enviar</button>
                                <a class="btn btn-outline-primary w-100 text-dark" href="index.php">Voltar</a>
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
        $('#fone').mask('(00) 00000-0000');
        $('#matricula').mask('00000000');
        $('#data').mask('00/00/0000');
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