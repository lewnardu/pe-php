<?php
session_start();
if (!empty($_SESSION['cpf'])) {

    $periodo_aberto = 0;

    include_once("conexao.php");
    ob_start();

    $myquery = "SELECT * FROM eventos WHERE descricao='DISPONIBILIDADE'";
    $myperiodo = mysqli_query($conexao, $myquery);
    $periodo = mysqli_fetch_row($myperiodo);


    $timestamp_inicio = strtotime($periodo[6] . ' ' . $periodo[7]);
    $inicio = date('Y-m-d H:i:s', $timestamp_inicio);
    $timestamp_final = strtotime($periodo[8] . ' ' . $periodo[9]);
    $final = date('Y-m-d H:i:s', $timestamp_final);

    if (date('Y-m-d H:i:s') >= $inicio and date('Y-m-d H:i:s') < $final) {
        $periodo_aberto = 1;
    }

    if ($periodo_aberto) {
        if (
            $_SESSION['extra'] == 'true'
        ) {

?>
            <!DOCTYPE html>
            <html>

            <head>
                <meta charset='utf-8' />
                <link href='css/core/main.css' rel='stylesheet' />
                <link href='css/daygrid/main.min.css' rel='stylesheet' />
                <link rel="stylesheet" href="css/bootstrap.css">
                <link rel="stylesheet" href="css/personalizado.css">
                <link rel="stylesheet" href="css/estilo.css">
                <link href="css/dashboard.css" rel="stylesheet">
                <link href="css/bootstrap.min.css" rel="stylesheet">
                <link href="blog.css" rel="stylesheet">


                <script src='js/core/main.min.js'></script>
                <script src='js/interaction/main.min.js'></script>
                <script src='js/daygrid/main.min.js'></script>
                <script src='js/core/locales/pt-br.js'></script>
                <script src="js/jquery.min.js"></script>
                <script src="js/1.14.7/umd/popper.min.js"></script>
                <script src="js/bootstrap.min.js"></script>
                <script src="js/personalizado.js"></script>


            </head>

            <body>
                <div class="container">
                    <header class="blog-header py-3">
                        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                            <h5 class="my-0 mr-md-auto font-weight-normal">Plantão Extra</h5>
                            <nav class="my-2 my-md-0 mr-md-3">
                                <a class="p-2 text-primary" href="../home.php">HOME</a>
                                <a class="p-2 text-dark" href="../edit_ag.php?mat=<?php echo $_SESSION['funcional']; ?>"><?php echo $_SESSION['nome']; ?></a>
                                <a class="p-2 text-dark" href=""><?php echo $_SESSION['funcional']; ?></a>
                            </nav>
                            <a class="btn btn-outline-danger" href="../sair.php">Sair</a>
                        </div>
                        <?php

                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }

                        include_once('conexao.php');
                        //ALTERAÇÃO MENSAL
                        $sql = "select * from demanda where inicio >= '2024-08-01 00:00' and nome='" . $_SESSION['nome'] . "'";
                        $result = mysqli_query($conexao, $sql);
                        $num = mysqli_num_rows($result);
                        $rest = $_SESSION['media'] - $num;

                        ?>
                        <h2 align="center"><?php echo $_SESSION['preferencia']; ?></h2><br>
                    </header>
                </div>

                <div class='conteiner'>
                    <div class="row">

                        <div class="col-md-2 d-none d-sm-block">
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0">EXTRAS DISPONIVEIS </h6>
                                        <small class="text-muted"></small>
                                    </div>
                                    <span class="text-muted">(<?php echo $rest; ?>)</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <svg class="bd-placeholder-img mr-2 rounded" width="32" height="22" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32">
                                        <rect width="100%" height="100%" fill="#FF8C00" />
                                    </svg> DIURNO
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <svg class="bd-placeholder-img mr-2 rounded" width="32" height="22" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 32x32">
                                        <rect width="100%" height="100%" fill="#48D1CC" />
                                    </svg> NOTURNO
                                </li>
                            </ul>

                            <a href='../home.php'><button type="button" class="btn btn-sm btn-outline-success btn-block">FINALIZAR</button></a>
                        </div>

                        <div id='calendar' text-center></div>
                        </section>
                        <div class="modal fade" id="visualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Detalhes</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="window.location.reload();">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="visevent">
                                            <dl class="row">
                                                <dt class="col-sm-3">N°</dt>
                                                <dd class="col-sm-9" id="id"></dd>

                                                <dt class="col-sm-3">Nome</dt>
                                                <dd class="col-sm-9" id="title"></dd>

                                                <dt class="col-sm-3"></dt>
                                                <dd class="col-sm-9">Verifique o horário com a unidade!</dd>

                                            </dl>
                                            <?php
                                            if ($rest > 0 && $rest <= $_SESSION['media']) {
                                                echo "<button class='btn btn-warning btn-canc-vis'>Editar</button>";
                                            }
                                            ?>
                                            <a href="" id="apagar_evento" class="btn btn-danger">Apagar</a>
                                        </div>
                                        <div class="formedit">
                                            <span id="msg-edit"></span>
                                            <form id="editevent" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" id="id">
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">nome</label>
                                                    <div class="col-sm-10">
                                                        <select class="custom-select" name="title">
                                                            <option value='<?php echo $_SESSION['nome']; ?>'><?php echo $_SESSION['nome']; ?> </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-sm-10">
                                                        <button type="button" class="btn btn-danger btn-canc-edit" onclick="window.location.reload();">Cancelar</button>
                                                        <button type="submit" name="CadEvent" id="CadEvent" value="CadEvent" class="btn btn-success">Salvar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- The Modal -->
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <p>A unidade de preferência escolhida por você para realizar plantão extra é:</p>
                                        </div>
                                        <div class="text-center text-success">
                                            <h2><?php echo $_SESSION['preferencia'] ?></h2>
                                        </div>
                                        <h3 class="text-center text-danger">Atenção!</h3>
                                        <p class=text-justify>Ao escolher as datas para realizar os plantões extraordinários, o servidor se responsabiliza
                                            por selecioná-las considerando seu período de trabalho regular, bem como o
                                            período mínimo de descanso constante na INSTRUÇÃO NORMATIVA SECIJU/TO Nº 03, publicada
                                            no Diário Oficial do Estado do Tocantins de nº 5720, de 09 de novembro de 2020. O não
                                            cumprimento das regras constantes na normativa supracitada poderá resultar em problemas
                                            no pagamento do plantão extra realizado.</p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- The Modal -->
                        <div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal2">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        <div class="text-center">
                                            <p>A unidade de preferência escolhida por você para realizar plantão extra é:</p>
                                        </div>
                                        <div class="text-center text-success">
                                            <h2><?php echo $_SESSION['preferencia'] ?></h2>
                                        </div>
                                        <h3 class="text-center text-danger">Atenção!</h3>
                                        <p class=text-justify>Você não cadastrou a disponibilidade para esse mês.</p>
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Confirmar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script type="text/javascript">
                            <?php

                            if ($num == 0) {
                                echo "$('#myModal').modal('show');";
                            }

                            ?>
                        </script>

            </body>

            </html>
<?php
        } else {
            $_SESSION['msg'] = "<div class='alert alert-warning'>Disponibilidade não cadastrada!</div>";
            header("Location: ../home.php");
        }
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Período indisponível. O prazo para agendar os plantões extraordinários ficou definido entre os períodos de {$inicio} até {$final}.</div>";

        header("Location: ../home.php");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
    header("Location: ../index.php");
}
?>