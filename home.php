<?php
session_start();
if (!empty($_SESSION['cpf'])) {
  $agora = time();

  if ($agora > $_SESSION['expira']) {
    session_destroy();
    $_SESSION['msg'] = "<div class='alert alert-success'> Sessão expirou!</div>";
    header("Location: index.php");
  } else {
    include_once 'escala/conexao.php';

    $sql = "SELECT * FROM eventos where id='1'";
    $result = mysqli_query($conexao, $sql);
    $disp = mysqli_fetch_assoc($result);


?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio</title>

    <link href="css/bootstrap.css" rel="stylesheet">
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

    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">

    <link href="blog.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
</head>

<body>
    <div class="container">

        <header class="blog-header py-3">
            <div
                class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <h5 class="my-0 mr-md-auto font-weight-normal">SPEx - SISTEMA DE PLANTÃO EXTRA</h5>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 text-dark"
                        href="edit_ag.php?mat=<?php echo $_SESSION['funcional']; ?>"><?php echo $_SESSION['nome']; ?></a>
                    <a class="p-2 text-dark" href=""><?php echo $_SESSION['funcional']; ?></a>
                </nav>
                <a class="btn btn-outline-danger" href="sair.php">Sair</a>
            </div>
            <?php
            if (isset($_SESSION['msg'])) {
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
            }
          ?>
        </header>

        <iframe width="100%" height="100%"
            src="https://relogioonline.com.br/embed/horario/#theme=1&color=2&ampm=0&showdate=1" frameborder="0"
            allowfullscreen></iframe>
        <p></p>

        <div class="row justify-content-md-center">
            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-danger">PLANTÃO EXTRA</strong>
                        <h3 class="mb-0">Manifestar Disponibilidade Para o Próximo Mês</h3><br>
                        <div class="mb-1 text-muted"></div><br>
                        <p class="card-text mb-auto">Os prazos para manifestar disponibilidade se encontram no banner do
                            início da página.</p><br>

                        <a href="edit_ag.php?mat=<?php echo $_SESSION['funcional']; ?>"
                            class="btn btn-sm btn-danger">Manifestar Disponibilidade</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="0" height="0" xmlns="http://www.w3.org/2000/svg"
                            preserveAspectRatio="xMidYMid slice" focusable="false" role="img"
                            aria-label="Placeholder: Thumbnail"><img src="imagens/plantao_extra.jpg" width="500"
                                height="275"></svg>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-primary">PLANTÃO EXTRA</strong>
                        <h3 class="mb-0">Escolher Datas e Turnos</h3><br>
                        <div class="mb-1 text-muted">
                            <?php echo date('d/m/Y', strtotime($disp['agend_data_inicial'])) . " às " . date('H:i', strtotime($disp['agend_hora_inicial'])) . " até " . date('d/m/Y', strtotime($disp['agend_data_final'])) . " às " . date('H:i', strtotime($disp['agend_hora_final'])); ?>
                        </div><br>

                        <p class="mb-auto">Escolha as datas e os turnos conforme a sua disponibilidade (Sujeitos a
                            alteração por disponibilidade). Os prazos para escolha se encontram no banner do início da
                            página.</p><br>

                        <a href="/PE/escala/extra.php" class="btn btn-sm btn-primary">Escolher</a>

                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="0" height="0" xmlns="http://www.w3.org/2000/svg"
                            preserveAspectRatio="xMidYMid slice" focusable="false" role="img"
                            aria-label="Placeholder: Thumbnail"><img src="imagens/cal.jpg" width="500"
                                height="300"></svg>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div
                    class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-dark">PLANTÃO EXTRA</strong>
                        <h3 class="mb-0">Consultar Datas e Turnos</h3><br>
                        <div class="mb-1 text-muted">A consulta é disponibilizada conforme a confirmação dos plantões
                            extras pela Administração Penal.</div><br>
                        <p class="card-text mb-auto">Consulte suas datas e períodos para realizar o plantão extra de
                            acordo com o mês.</p><br>
                        <form action="exibepdf.php" method="post">
                            <div class="d-flex p-1">
                                <label for="datePicker">Data/Mês do Extra:</label>
                                <input type="date" id="datePicker" class="form-control" name="mesDoExtra"
                                    value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <br>
                            <input type="submit" value="Consultar" class="btn btn-sm btn-dark btn-block">
                        </form>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                        <svg class="bd-placeholder-img" width="0" height="0" xmlns="http://www.w3.org/2000/svg"
                            preserveAspectRatio="xMidYMid slice" focusable="false" role="img"
                            aria-label="Placeholder: Thumbnail"><img src="imagens/hora2.jpg" width="500"
                                height="275"></svg>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- html do modal -->
    <div class="modal fade" style="background-color:red" id="avisomodal" tabindex="-1" role="dialog"
        aria-labelledby="modalrestricao" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pmodal pmodal-center" id="modalrestricao">Aviso Importante!</h5>
                </div>
                <div class="modal-body">
                    <p class="pmodal pmodal-center">ATENÇÃO SERVIDOR,</p>
                    <p class="pmodal">
                    <p>Conforme acertado com a SECAD, informamos que a folha de lançamento dos plantões extraordinários
                        foi alterada em virtude das recorrentes recusas no pagamento, por não haver tempo hábil para o
                        recebimento, tratamento e conferências necessárias.
                        Desta forma, a SECIJU foi orientada a proceder o lançamento dos Plantões Extraordinários na
                        segunda folha posterior à realização dos plantões.
                    </p>
                    <p>Exemplo: Pagamento de plantões extras realizados no mês de março será organizado no mês de abril
                        e submetido para pagamento em maio, para recebimento no início de junho.

                    </p>
                </div>
                <div class="modal-footer">
                    <button id="pmodal" type="button" class="btn btn-danger" data-dismiss="modal">Estou ciente</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <script>
    $('#avisomoda').modal('show');
    </script>

    <p class="mt-5 mb-3 text-muted text-center">Setor de Gestão Tecnológica - SGT/SISPEN . Todos os direitos reservados.
        &copy;2020-2024
</body>

</html>
<?php
  }
} else {
  $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
  header("Location: index.php");
}
?>