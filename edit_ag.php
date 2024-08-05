<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (!empty($_SESSION['cpf'])) {

  $periodo_aberto = 0;

  include_once("conexao.php");
  ob_start();

  $myquery = "SELECT * FROM eventos WHERE descricao='DISPONIBILIDADE'";
  $myperiodo = mysqli_query($conexao2, $myquery);
  $periodo = mysqli_fetch_row($myperiodo);

  $timestamp_inicio = strtotime($periodo[2] . ' ' . $periodo[3]);
  $inicio = date('Y-m-d H:i:s', $timestamp_inicio);
  $timestamp_final = strtotime($periodo[4] . ' ' . $periodo[5]);
  $final = date('Y-m-d H:i:s', $timestamp_final);

  if (date('Y-m-d H:i:s') >= $inicio and date('Y-m-d H:i:s') < $final) {
    $periodo_aberto = 1;
  }

  if ($periodo_aberto) {

    $id = filter_input(INPUT_GET, 'mat', FILTER_SANITIZE_STRING);

    $sq = "SELECT * FROM aep where funcional='$id'";
    $res = mysqli_query($conexao, $sq);
    $plan = mysqli_fetch_assoc($res);

    if ($plan['extra'] != 'true') {

      $carimbo = date('Y-m-d H:i:s');
      $codigo = password_hash($carimbo . ":" . $dados['matricula'], PASSWORD_DEFAULT);
      $cadastrar = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_STRING);
      if ($cadastrar) {
        $dadosS = filter_input_array(INPUT_POST, FILTER_DEFAULT);


        $erro = false;
        $dadosT = array_map('strip_tags', $dadosS);  //retirando as tag
        $dados = array_map('trim', $dadosT);  //retirando os espaços

        if ($dados['extra'] != 'true') {
          $erro = true;
        }

        if (!$erro) {

          $query = "UPDATE aep SET nome='" . $dados['nome'] . "',
					 	`e-mail`='" . $dados['email'] . "',
					 	 funcional='" . $dados['matricula'] . "', 
					 	 cpf='" . $dados['cpf'] . "',
					 	 vinculo='" . $dados['vinculo'] . "',
					 	 cf='" . $dados['cf'] . "',
					 	 sexo='" . $dados['sexo'] . "',
					 	 dtnasc='" . $dados['dtnasc'] . "',
					 	 jornada='" . $dados['jornada'] . "',
					 	 fone='" . $dados['fone'] . "',
					 	 cidade='" . $dados['cidade'] . "',
					 	 equipe='" . $dados['equipe'] . "',
					 	 `lotação`='" . $dados['unidade'] . "',
					 	 `restrição`='" . $dados['restrição'] . "',
					 	 `extra`='" . $dados['extra'] . "',
					 	 preferencia='" . $dados['preferencia'] . "',
					 	 carimbo='" . $carimbo . "',
             codigo='" . $codigo . "'
			WHERE funcional='$id'";

          mysqli_query($conexao, $query);

          if (mysqli_affected_rows($conexao)) {

            $_SESSION['preferencia'] = $dados['preferencia'];
            $_SESSION['restrição'] = $dados['restrição'];

            //	echo "<script> alert('Cadastrado com sucesso!'); window.location='exibeComp.php?matricula=".$_SESSION['funcional']."'; </script>";
            echo "<script> alert('Cadastrado com sucesso!'); </script>";
            header("Location: exibeComp.php?matricula=" . $_SESSION['funcional'] . "");
            //$_SESSION['msg'] = "<div class='alert alert-success'> Cadastrado com sucesso!</div>";
            //header("Location: home.php");		
          } else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao editar cadastro!</div>";
          }

          //header("Location: home.php");
        } else {
          //echo "<script> document.location.reload(true); </script>";
          $_SESSION['msg'] = "<div class='alert alert-danger'>Erro ao cadastrar! Aceite os termos da instrução normativa.</div>";
        }
      }

?>
      <!doctype html>
      <html lang="pt-br">

      <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Editar plantonista</title>


        <link href="css/bootstrap.min.css" rel="stylesheet">


        <link href="form-validation.css" rel="stylesheet">
        <link href="css/dashboard.css" rel="stylesheet">
      </head>

      <body class="bg-light">
        <div class="container">
          <header class="blog-header py-3">
            <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
              <h5 class="my-0 mr-md-auto font-weight-normal">Plantão Extra</h5>
              <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-primary" href="home.php">HOME</a>
                <a class="p-2 text-dark" href="edit_ag.php?mat=<?php echo $_SESSION['funcional']; ?>"><?php echo $_SESSION['nome']; ?></a>
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
        </div>
        <div class="container">
          <div class="py-4 text-center">
            <img class="mb-4" src="imagens/logoSP.png" alt="" width="78" height="90">
            <h2>Editar ficha do plantonista</h2>
          </div>

          <div class="col-md-12 order-md-1">

            <form class="needs-validation" method="POST" action="">
              <div class="row">

                <div class="col-md-6 mb-3">
                  <label for="address2">Nome</label>
                  <input type="text" class="form-control" name="nome" placeholder="Nome completo" value="<?php echo $plan['nome']; ?>" required readonly>
                  <div class="invalid-feedback">
                    Requer um nome válido.
                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="address2">CPF</label>
                  <input type="text" class="form-control" name="cpf" placeholder="000.000.000-00" value="<?php echo $plan['cpf']; ?>" required readonly>
                  <div class="invalid-feedback">
                    CPF inválido.
                  </div>
                </div>

                <div class="col-md-4 mb-3">
                  <label for="address2">E-mail </label>
                  <input type="email" class="form-control" name="email" placeholder="plantonista@examplo.com" value="<?php echo $plan['e-mail']; ?>" required>
                  <div class="invalid-feedback">
                    E-mail inválido.
                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="address2">Matricula</label>
                  <input type="text" class="form-control" name="matricula" placeholder="0000000" value="<?php echo $plan['funcional']; ?>" required readonly>
                  <div class="invalid-feedback">
                    Matricula inválida.
                  </div>
                </div>

                <div class="col-md-1 mb-3">
                  <label for="address2">Vinculo</label>
                  <input type="text" class="form-control" name="vinculo" placeholder="0" value="<?php echo $plan['vinculo']; ?>" required readonly>
                  <div class="invalid-feedback">
                    Matricula inválida.
                  </div>
                </div>

                <div class="col-md-1 mb-3">
                  <label for="address2">sexo</label>
                  <input type="text" class="form-control" name="sexo" value="<?php echo $plan['sexo']; ?>" required readonly>
                  <div class="invalid-feedback">

                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="address2">data de nascimento</label>
                  <input type="text" class="form-control" name="dtnasc" placeholder="00/00/0000" value="<?php echo $plan['dtnasc']; ?>" required readonly>
                  <div class="invalid-feedback">
                    Data de nascimento invalida
                  </div>
                </div>



                <div class="col-md-2 mb-3">
                  <label for="zip">Telefone</label>
                  <input type="text" class="form-control" name="fone" placeholder="0000000000" value="<?php echo $plan['fone']; ?>" required>
                  <div class="invalid-feedback">
                    Telefone inválido.
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label for="address2">Cidade onde reside</label>
                  <select class="custom-select d-block w-100" name="cidade" required>
                    <option></option>
                    <option value="Abreulândia">Abreulândia</option>
                    <option value="Aguiarnópolis">Aguiarnópolis</option>
                    <option value="Aliança do Tocantins">Aliança do Tocantins</option>
                    <option value="Almas">Almas</option>
                    <option value="Alvorada">Alvorada</option>
                    <option value="Ananás">Ananás</option>
                    <option value="Angico">Angico</option>
                    <option value="Aparecida do Rio Negro">Aparecida do Rio Negro</option>
                    <option value="Aragominas">Aragominas</option>
                    <option value="Araguacema">Araguacema</option>
                    <option value="Araguaçu">Araguaçu</option>
                    <option value="Araguaína">Araguaína</option>
                    <option value="Araguanã">Araguanã</option>
                    <option value="Araguatins">Araguatins</option>
                    <option value="Arapoema">Arapoema</option>
                    <option value="Arraias">Arraias</option>
                    <option value="Augustinópolis">Augustinópolis</option>
                    <option value="Aurora do Tocantins">Aurora do Tocantins</option>
                    <option value="Axixá do Tocantins">Axixá do Tocantins</option>
                    <option value="Babaçulândia">Babaçulândia</option>
                    <option value="Bandeirantes do Tocantins">Bandeirantes do Tocantins</option>
                    <option value="Barra do Ouro">Barra do Ouro</option>
                    <option value="Barrolândia">Barrolândia</option>
                    <option value="Bernardo Sayão">Bernardo Sayão</option>
                    <option value="Bom Jesus do Tocantins">Bom Jesus do Tocantins</option>
                    <option value="Brasilândia do Tocantins">Brasilândia do Tocantins</option>
                    <option value="Brejinho de Nazaré">Brejinho de Nazaré</option>
                    <option value="Buriti do Tocantins">Buriti do Tocantins</option>
                    <option value="Cachoeirinha">Cachoeirinha</option>
                    <option value="Campos Lindos">Campos Lindos</option>
                    <option value="Cariri do Tocantins">Cariri do Tocantins</option>
                    <option value="Carmolândia">Carmolândia</option>
                    <option value="Carrasco Bonito">Carrasco Bonito</option>
                    <option value="Caseara">Caseara</option>
                    <option value="Centenário">Centenário</option>
                    <option value="Chapada da Natividade">Chapada da Natividade</option>
                    <option value="Chapada de Areia">Chapada de Areia</option>
                    <option value="Colinas do Tocantins">Colinas do Tocantins</option>
                    <option value="Colméia">Colméia</option>
                    <option value="Combinado">Combinado</option>
                    <option value="Conceição do Tocantins">Conceição do Tocantins</option>
                    <option value="Couto Magalhães">Couto Magalhães</option>
                    <option value="Cristalândia">Cristalândia</option>
                    <option value="Crixás do Tocantins">Crixás do Tocantins</option>
                    <option value="Darcinópolis">Darcinópolis</option>
                    <option value="Dianópolis">Dianópolis</option>
                    <option value="Divinópolis do Tocantins">Divinópolis do Tocantins</option>
                    <option value="Dois Irmãos do Tocantins">Dois Irmãos do Tocantins</option>
                    <option value="Dueré">Dueré</option>
                    <option value="Esperantina">Esperantina</option>
                    <option value="Fátima">Fátima</option>
                    <option value="Figueirópolis">Figueirópolis</option>
                    <option value="Filadélfia">Filadélfia</option>
                    <option value="Formoso do Araguaia">Formoso do Araguaia</option>
                    <option value="Goianorte">Goianorte</option>
                    <option value="Goiatins">Goiatins</option>
                    <option value="Guaraí">Guaraí</option>
                    <option value="Gurupi">Gurupi</option>
                    <option value="Ipueiras">Ipueiras</option>
                    <option value="Itacajá">Itacajá</option>
                    <option value="Itaguatins">Itaguatins</option>
                    <option value="Itapiratins">Itapiratins</option>
                    <option value="Itaporã do Tocantins">Itaporã do Tocantins</option>
                    <option value="Jaú do Tocantins">Jaú do Tocantins</option>
                    <option value="Juarina">Juarina</option>
                    <option value="Lagoa da Confusão">Lagoa da Confusão</option>
                    <option value="Lagoa do Tocantins">Lagoa do Tocantins</option>
                    <option value="Lajeado">Lajeado</option>
                    <option value="Lavandeira">Lavandeira</option>
                    <option value="Lizarda">Lizarda</option>
                    <option value="Luzinópolis">Luzinópolis</option>
                    <option value="Marianópolis do Tocantins">Marianópolis do Tocantins</option>
                    <option value="Mateiros">Mateiros</option>
                    <option value="Maurilândia do Tocantins">Maurilândia do Tocantins</option>
                    <option value="Miracema do Tocantins">Miracema do Tocantins</option>
                    <option value="Miranorte">Miranorte</option>
                    <option value="Monte do Carmo">Monte do Carmo</option>
                    <option value="Monte Santo do Tocantins">Monte Santo do Tocantins</option>
                    <option value="Muricilândia">Muricilândia</option>
                    <option value="Natividade">Natividade</option>
                    <option value="Nazaré">Nazaré</option>
                    <option value="Nova Olinda">Nova Olinda</option>
                    <option value="Nova Rosalândia">Nova Rosalândia</option>
                    <option value="Novo Acordo">Novo Acordo</option>
                    <option value="Novo Alegre">Novo Alegre</option>
                    <option value="Novo Jardim">Novo Jardim</option>
                    <option value="Oliveira de Fátima">Oliveira de Fátima</option>
                    <option value="Outros">Outros</option>
                    <option value="Palmas">Palmas</option>
                    <option value="Palmeirante">Palmeirante</option>
                    <option value="Palmeiras do Tocantins">Palmeiras do Tocantins</option>
                    <option value="Palmeirópolis">Palmeirópolis</option>
                    <option value="Paraíso do Tocantins">Paraíso do Tocantins</option>
                    <option value="Paranã">Paranã</option>
                    <option value="Pau-d'Arco">Pau-d'Arco</option>
                    <option value="Pedro Afonso">Pedro Afonso</option>
                    <option value="Peixe">Peixe</option>
                    <option value="Pequizeiro">Pequizeiro</option>
                    <option value="Pindorama do Tocantins">Pindorama do Tocantins</option>
                    <option value="Piraquê">Piraquê</option>
                    <option value="Pium">Pium</option>
                    <option value="Ponte Alta do Bom Jesus">Ponte Alta do Bom Jesus</option>
                    <option value="Ponte Alta do Tocantins">Ponte Alta do Tocantins</option>
                    <option value="Porto Alegre do Tocantins">Porto Alegre do Tocantins</option>
                    <option value="Porto Nacional">Porto Nacional</option>
                    <option value="Praia Norte">Praia Norte</option>
                    <option value="Presidente Kennedy">Presidente Kennedy</option>
                    <option value="Pugmil">Pugmil</option>
                    <option value="Recursolândia">Recursolândia</option>
                    <option value="Riachinho">Riachinho</option>
                    <option value="Rio da Conceição">Rio da Conceição</option>
                    <option value="Rio dos Bois">Rio dos Bois</option>
                    <option value="Rio Sono">Rio Sono</option>
                    <option value="Sampaio">Sampaio</option>
                    <option value="Sandolândia">Sandolândia</option>
                    <option value="Santa Fé do Araguaia">Santa Fé do Araguaia</option>
                    <option value="Santa Maria do Tocantins">Santa Maria do Tocantins</option>
                    <option value="Santa Rita do Tocantins">Santa Rita do Tocantins</option>
                    <option value="Santa Rosa do Tocantins">Santa Rosa do Tocantins</option>
                    <option value="Santa Tereza do Tocantins">Santa Tereza do Tocantins</option>
                    <option value="Santa Terezinha do Tocantins">Santa Terezinha do Tocantins</option>
                    <option value="São Bento do Tocantins">São Bento do Tocantins</option>
                    <option value="São Félix do Tocantins">São Félix do Tocantins</option>
                    <option value="São Miguel do Tocantins">São Miguel do Tocantins</option>
                    <option value="São Salvador do Tocantins">São Salvador do Tocantins</option>
                    <option value="São Sebastião do Tocantins">São Sebastião do Tocantins</option>
                    <option value="São Valério">São Valério</option>
                    <option value="Silvanópolis">Silvanópolis</option>
                    <option value="Sítio Novo do Tocantins">Sítio Novo do Tocantins</option>
                    <option value="Sucupira">Sucupira</option>
                    <option value="Tabocão">Tabocão</option>
                    <option value="Taguatinga">Taguatinga</option>
                    <option value="Taipas do Tocantins">Taipas do Tocantins</option>
                    <option value="Talismã">Talismã</option>
                    <option value="Tocantínia">Tocantínia</option>
                    <option value="Tocantinópolis">Tocantinópolis</option>
                    <option value="Tupirama">Tupirama</option>
                    <option value="Tupiratins">Tupiratins</option>
                    <option value="Wanderlândia">Wanderlândia</option>
                    <option value="Xambioá">Xambioá</option>
                  </select>
                </div>

                <div class="col-md-1 mb-3">
                  <label for="address2">CF</label>
                  <input type="text" class="form-control" name="cf" placeholder="0" value="<?php echo $plan['cf']; ?>" required readonly>
                  <div class="invalid-feedback">
                    Curso de formação invalido
                  </div>
                </div>

                <?php

                $sql = "SELECT DISTINCT `lotação` FROM aep order by `lotação`";
                $resultado = mysqli_query($conexao, $sql);

                include_once("escala/conexao.php");
                $consul = "SELECT DISTINCT nome FROM unidades where extra='sim' order by nome";
                $result = mysqli_query($conexao, $consul);
                ?>


                <div class="col-md-8 mb-3">
                  <label for="state">Lotação</label>
                  <select class="custom-select d-block w-100" name="unidade" required>
                    <option value="<?php echo $plan['lotação']; ?>"><?php echo $plan['lotação']; ?></option>
                    <?php
                    while ($linha = mysqli_fetch_array($resultado)) {
                      $unidade = $linha['lotação'];
                      echo "<option value='" . $unidade . "'>" . $unidade . "</option>";
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Requer lotação válida.
                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="state">Jornada</label>
                  <select class="custom-select d-block w-100" name="jornada">
                    <option value=""></option>
                    <option <?php if ($plan['jornada'] == 'Plantão') {
                              echo "selected";
                            } ?> value="Plantão">Plantão</option>
                    <option <?php if ($plan['jornada'] == 'Expediente') {
                              echo "selected";
                            } ?> value="Expediente">Expediente</option>
                  </select>
                  <div class="invalid-feedback">
                    Jornada inválida
                  </div>
                </div>

                <div class="col-md-2 mb-3">
                  <label for="state">Equipe</label>
                  <select class="custom-select d-block w-100" name="equipe">
                    <option value="<?php echo $plan['equipe']; ?>"><?php echo $plan['equipe']; ?> </option>
                    <option value=""></option>
                    <option value="Alfa">ALFA</option>
                    <option value="Bravo">BRAVO</option>
                    <option value="Charlie">CHARLIE</option>
                    <option value="Delta">DELTA</option>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="state">Preferência</label>
                  <select class="custom-select d-block w-100" name="preferencia" value="<?php echo $plan['preferencia']; ?>" required>
                    <option value=""></option>
                    <!--    <option value="<?php echo $plan['preferencia']; ?>"><?php echo $plan['preferencia']; ?></option> -->

                    <?php
                    while ($linha = mysqli_fetch_array($result)) {
                      $unid = $linha['nome'];
                      echo "<option value='" . $unid . "'>" . $unid . "</option>";
                    }
                    ?>
                  </select>
                  <div class="invalid-feedback">
                    Requer unidade válida.
                  </div>
                </div>

                <div class="col-md-3 mb-3">
                  <label for="state">Restrição</label>
                  <select class="custom-select d-block w-100" name="restrição">
                    <option value=""></option>
                    <option value="férias" <?php if ($plan['restrição'] == 'férias') {
                                              echo "selected";
                                            } ?>>FÉRIAS</option>
                    <option value="atestado" <?php if ($plan['restrição'] == 'atestado') {
                                                echo "selected";
                                              } ?>>ATESTADO MÉDICO</option>
                  </select>
                </div>

                <div class="col-md-3 mb-3">
                  <label for="address2">cargo</label>
                  <input type="text" class="form-control" name="cargo" placeholder="" value="<?php echo $plan['cargo']; ?>" required readonly>
                  <div class="invalid-feedback">
                    Curso de formação inválido
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="true" name="extra" <?php if ($plan['extra'] == true) {
                                                                                                echo "checked";
                                                                                              } ?>>
                    <label class="form-check-label" for="defaultCheck1">
                      Eu me disponho a realizar plantão extraordinário no mês seguinte e, também, declaro que estou ciente de todas as definições impostas ao plantão extraordinário através da <a href="Instrução.pdf" target="_blank">INSTRUÇÃO NORMATIVA SECIJU/TO Nº 03, DE 09 DE NOVEMBRO DE 2020</a>, publicada no Diário Oficial do Estado, edição nº 5720, de 09 de novembro de 2020.
                    </label>
                  </div>
                </div>
                <div class="col-md-12 mb-3">
                  <button class="btn btn-danger btn-lg btn-block" name="editar" value="true" type="submit">cadastrar</button>
                </div>
            </form>
          </div>
        </div><br>
        <script>
          window.jQuery || document.write('<script src="/docs/4.5/assets/js/vendor/jquery.slim.min.js"><\/script>')
        </script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/form-validation.js"></script>
        <p class="mt-5 mb-3 text-muted text-center">SGT - &copy; 2020</p>
      </body>

      </html>
<?php
    } else {
      $_SESSION['msg'] = "<div class='alert alert-danger'>Usuário já cadastrado!</div>";
      header("Location: home.php");
    }
  } else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Período indisponível para cadastro! O período previsto é de $inicio até $final.</div>";
    header("Location: home.php");
  }
} else {
  $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não logado!</div>";
  header("Location: index.php");
}
?>