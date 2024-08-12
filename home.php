<?php
require_once('registro/home.php');
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Inicio</title>

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/home.css" rel="stylesheet">

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
                    <a class="p-2 text-dark" href=""><?php echo $_SESSION['nome']; ?></a>
                    <a class="p-2 text-dark" href=""><?php echo $_SESSION['funcional']; ?></a>
                </nav>
                <a class="btn btn-outline-danger" href="/registro/sair.php">Sair</a>
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
                        <h3 class="mb-0">Manifestar Disponibilidade Para o Próximo Mês</h3>
                        <div class="mb-1 text-muted"></div>
                        <p class="card-text mb-auto">Os prazos para manifestar disponibilidade se encontram no banner do
                            início da página.</p>

                        <a href="perfil.php" class="btn btn-sm btn-danger">Manifestar Disponibilidade</a>
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
                        <h3 class="mb-0">Escolher Datas e Turnos</h3>
                        <div class="mb-1 text-muted">
                            <?php echo date('d/m/Y', strtotime($disp['agend_data_inicial'])) . " às " . date('H:i', strtotime($disp['agend_hora_inicial'])) . " até " . date('d/m/Y', strtotime($disp['agend_data_final'])) . " às " . date('H:i', strtotime($disp['agend_hora_final'])); ?>
                        </div>

                        <p class="mb-auto">Escolha as datas e os turnos conforme a sua disponibilidade (Sujeitos a
                            alteração por disponibilidade). Os prazos para escolha se encontram no banner do início da
                            página.</p>

                        <a href="escala/extra.php" class="btn btn-sm btn-primary">Escolher</a>

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
                        <h3 class="mb-0">Consultar Agendamentos</h3>
                        <div class="mb-1 text-muted">O relatório de agendamenos reflete os agendamentos realizados,
                            porém sua homologação depende da finalização da fase de agendamentos pela COPEX.</div>
                        <p class="card-text mb-auto ">Selecione o período de agendamentos para consultar.</p>
                        <form action="registro/agendamentos.php" method="post">
                            <div class="form-label-group mb-3">
                                <label for="datePicker">Mês do Agendamento:</label>
                                <input type="month" id="datePicker" class="form-control" name="mesDoExtra">
                            </div>
                            <div class="bnt-group">
                                <button class="btn btn-dark w-100" type="submit">Consultar</button>
                            </div>
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

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <p class="text-center text-muted">&copy; Setor de Gestão Tecnológica - SGT 2020-2024</p>
        </div>
    </footer>

    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</body>

</html>