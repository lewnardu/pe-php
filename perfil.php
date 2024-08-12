<?php
// session_start();
require_once('registro/perfil.php');
// ob_start();
?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perfil do Plantonista</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="form-validation.css" rel="stylesheet">
    <link href="css/dashboard.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container">
        <header class="blog-header py-3">
            <div
                class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
                <h5 class="my-0 mr-md-auto font-weight-normal">Plantão Extra</h5>
                <nav class="my-2 my-md-0 mr-md-3">
                    <a class="p-2 text-primary" href="home.php">HOME</a>
                    <a class="p-2 text-dark" href="#"><?php echo $_SESSION['nome']; ?></a>
                    <a class="p-2 text-dark" href="#"><?php echo $_SESSION['funcional']; ?></a>
                </nav>
                <a class="btn btn-outline-danger" href="registro/sair.php">Sair</a>
            </div>
        </header>
        <?php
            if (isset($_SESSION['msg'])) {
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
            }
            ?>
    </div>
    <div class="container">
        <div class="py-4 text-center">
            <img class="mb-4" src="imagens/logoSP.png" alt="" width="78" height="90">
            <h2>Perfil do Plantonista</h2>
        </div>
        <form class="needs-validation" method="POST" action="registro/disponibilidade.php">
            <div class="form-row">
                <div class="col-12 col-lg-8 mb-3">
                    <label for="nome">Nome</label>
                    <input type="text" class="form-control" name="nome" placeholder="Digite o nome completo"
                        value="<?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : ''; ?>" required readonly>
                    <div class="invalid-feedback">
                        O campo nome é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <label for="cpf">CPF</label>
                    <input type="text" class="form-control" name="cpf" placeholder="___.___.___-__"
                        value="<?php echo isset($_SESSION['cpf']) ? $_SESSION['cpf'] : ''; ?>" required readonly>
                    <div class="invalid-feedback">
                        O campo CPF é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <label for="cargo">Cargo</label>
                    <input type="text" class="form-control" name="cargo" placeholder=""
                        value="<?php echo isset($_SESSION['cargo']) ? $_SESSION['cargo'] : ''; ?>" required readonly>
                    <div class="invalid-feedback">
                        O campo Cargo é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <label for="matricula">Matricula</label>
                    <input type="text" class="form-control" name="matricula" placeholder="Digite a matrícula"
                        value="<?php echo isset($_SESSION['funcional']) ? $_SESSION['funcional'] : ''; ?>" required
                        readonly>
                    <div class="invalid-feedback">
                        O campo Matrícula é obrigatório.
                    </div>
                </div>

                <div class="col-4 col-md-2 mb-3">
                    <label for="vinculo">Vinculo</label>
                    <input type="text" class="form-control" name="vinculo" placeholder="Digite o vínculo"
                        value="<?php echo isset($_SESSION['vinculo']) ? $_SESSION['vinculo'] : ''; ?>" required
                        readonly>
                    <div class="invalid-feedback">
                        O campo Vínculo é obrigatório.
                    </div>
                </div>

                <div class="col-4 col-md-2 mb-3">
                    <label for="sexo">Gênero</label>
                    <input type="text" class="form-control" name="sexo"
                        value="<?php echo isset($_SESSION['sexo']) ? $_SESSION['sexo'] : ''; ?>" required readonly>
                    <div class="invalid-feedback">
                        O campo Gênero é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 col-xl-3 mb-3">
                    <label for="dtnasc">Data de Nascimento</label>
                    <input type="text" class="form-control" name="dtnasc"
                        value="<?php echo isset($_SESSION['dtnasc']) ? $_SESSION['dtnasc'] : ''; ?>" required readonly>
                    <div class="invalid-feedback">
                        O campo Data de Nascimento é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                    <label for="e-mail">E-mail </label>
                    <input type="email" class="form-control" name="e-mail" placeholder="email@examplo.com"
                        value="<?php echo isset($_SESSION['e-mail']) ? $_SESSION['e-mail'] : ''; ?>" required>
                    <div class="invalid-feedback">
                        O campo E-mail é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-4 col-lg-4 col-xl-3 mb-3">
                    <label for="fone">Telefone</label>
                    <input type="text" id="fone" class="form-control" name="fone" placeholder="(00) 00000-0000"
                        value="<?php echo isset($_SESSION['fone']) ? $_SESSION['fone'] : ''; ?>" required>
                    <div class="invalid-feedback">
                        O campo Telefone é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-8 mb-3">
                    <label for="cidade">Município</label>
                    <select class="custom-select d-block w-100" name="cidade" id="cidade"
                        data-cidade-sessao="<?php echo isset($_SESSION['cidade']) ? $_SESSION['cidade'] : ''; ?>"
                        required>
                        <option value="">Selecione o município</option>
                    </select>
                    <div class="invalid-feedback">
                        O campo Município é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <label for="restricao">Restrição Administrativa</label>
                    <select class="custom-select d-block w-100" name="restricao">
                        <option value="">Selecione</option>
                    </select>
                </div>

                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <label for="cf">Curso de Formação</label>
                    <select class="custom-select d-block w-100" name="cf">
                        <option value="">Selecione</option>
                        <?php foreach ($cursos_formacao as $curso) : ?>
                        <option value="<?php echo $curso['value']; ?>"
                            <?php echo isset($_SESSION['cf']) && $_SESSION['cf'] === $curso['value'] ? 'selected' : ''; ?>>
                            <?php echo $curso['descricao']; ?>
                        </option>
                        <?php endforeach; ?>

                    </select>
                    <div class="invalid-feedback">
                        O campo Curso de Formação é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <label for="jornada">Jornada de Trabalho</label>
                    <select class="custom-select d-block w-100" name="jornada">
                        <option value="">Selecione</option>
                        <option <?php if (isset($_SESSION['jornada']) && $_SESSION['jornada'] == 'Plantão') {
                  echo "selected";
                } ?> value="Plantão">PLANTÃO</option>
                        <option <?php if (isset($_SESSION['jornada']) && $_SESSION['jornada'] == 'Expediente') {
                  echo "selected";
                } ?> value="Expediente">EXPEDIENTE</option>
                    </select>
                    <div class="invalid-feedback">
                        O campo Jornada de Trabalho é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-4 mb-3">
                    <label for="equipe">Equipe</label>
                    <select class="custom-select d-block w-100" name="equipe">
                        <option value="">Selecione</option>
                        <?php foreach ($equipes as $equipe) : ?>
                        <option value="<?php echo $equipe['value']; ?>"
                            <?php echo isset($_SESSION['equipe']) && $_SESSION['equipe'] === $equipe['value'] ? 'selected' : ''; ?>>
                            <?php echo $equipe['descricao']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        O campo Equipe é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-8 mb-3">
                    <label for="unidade">Unidade de Lotação</label>
                    <select class="custom-select d-block w-100" name="unidade" required>
                        <option value="">
                            Selecione a Unidade de Lotação
                        </option>
                        <?php foreach ($lotacoes as $lotacao) : ?>
                        <option value="<?php echo $lotacao['lotação']; ?>"
                            <?php echo isset($_SESSION['lotação']) && $_SESSION['lotação'] === $lotacao['lotação'] ? 'selected' : ''; ?>>
                            <?php echo $lotacao['lotação']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        O campo Unidade de Lotação é obrigatório.
                    </div>
                </div>

                <div class="col-12 col-md-6 mb-3">
                    <label for="preferencia">Unidade de Preferência</label>
                    <select class="custom-select d-block w-100" name="preferencia" required>
                        <option value="">
                            Selecione a Unidade de Preferência
                        </option>
                        <?php foreach ($unidades as $unidade) : ?>
                        <option value="<?php echo $unidade['nome']; ?>"
                            <?php echo isset($_SESSION['preferencia']) && $_SESSION['preferencia'] === $unidade['nome'] ? 'selected' : ''; ?>>
                            <?php echo $unidade['nome']; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        O campo Unidade de Preferência é obrigatório.
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="extra" <?php if (isset($_SESSION['extra']) && $_SESSION['extra'] == true) {
                                                                          echo "checked";
                                                                        } ?>>
                        <label class="form-check-label" for="extra">
                            Eu me disponho a realizar plantão extraordinário no mês seguinte e, também,
                            declaro que
                            estou ciente de todas as definições impostas ao plantão extraordinário através
                            da <a href="Instrução.pdf" target="_blank">INSTRUÇÃO NORMATIVA SECIJU/TO Nº 03,
                                DE 09 DE NOVEMBRO DE 2020</a>, publicada no Diário Oficial do Estado, edição nº 5720,
                            de 09 de novembro de 2020.
                        </label>
                    </div>
                </div>
            </div>
            <div class="bnt-group">
                <button class="btn btn-outline-success w-100" type="submit">Cadastrar
                    Disponibilidade</button>
            </div>
        </form>
    </div>
    <script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.mask.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script src="js/form-validation.js"></script>
    <script>
    $(document).ready(function() {
        $('#fone').mask('(00)00000-0000');
    });
    </script>
    <script>
    $(document).ready(function() {
        const $uf = 'TO';
        let $select = $('#cidade');
        $.ajax({
            url: `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${$uf}/municipios`,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                $select.empty();
                $select.append(
                    '<option value="">Selecione o município</option>');

                $.each(data, function(index, municipio) {
                    $select.append(
                        `<option value="${municipio.nome}">${municipio.nome}</option>`
                    );
                });
                let cidadeSessao = $select.data('cidade-sessao');
                if (cidadeSessao) {
                    $select.val(cidadeSessao);
                }
            },
            error: function() {
                alert('Não foi possível carregar a lista de municípios.');
            }
        });
    });
    </script>
</body>

</html>