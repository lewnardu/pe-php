<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once('../Database.php');
$conexaoPle = new Database('DB_NAME_PLE');
$conexaoExt = new Database('DB_NAME_EXT');

if (!empty($_SESSION['cpf'])) {
    $query = "SELECT * FROM eventos WHERE descricao=:descricao";
    $resultado = $conexaoPle->query($query, [':descricao' => 'DISPONIBILIDADE']);
    $periodo = $resultado[0];

    $inicio = date('Y-m-d H:i:s', strtotime($periodo["disp_data_inicial"]." ".$periodo["disp_hora_inicial"]));
    $final = date('Y-m-d H:i:s', strtotime($periodo["disp_data_final"]." ".$periodo["disp_hora_final"]));
    
    $periodo_aberto = (date('Y-m-d H:i:s') >= $inicio and date('Y-m-d H:i:s') < $final) ? true : false;
    
    $email = filter_input(INPUT_POST, 'e-mail', FILTER_SANITIZE_EMAIL);
    $cf = filter_input(INPUT_POST, 'cf', FILTER_SANITIZE_SPECIAL_CHARS);
    $jornada = filter_input(INPUT_POST, 'jornada', FILTER_SANITIZE_SPECIAL_CHARS);  
    $fone = filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_NUMBER_INT);
    $fone = preg_replace('/\D/', '', $fone);
    $cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
    $equipe = filter_input(INPUT_POST, 'equipe', FILTER_SANITIZE_SPECIAL_CHARS);
    $unidade = filter_input(INPUT_POST, 'unidade', FILTER_SANITIZE_SPECIAL_CHARS);
    $preferencia = filter_input(INPUT_POST, 'preferencia', FILTER_SANITIZE_SPECIAL_CHARS);
    $extra = filter_input(INPUT_POST, 'extra', FILTER_SANITIZE_SPECIAL_CHARS);

    $carimbo = date('Y-m-d H:i:s');
    $codigo = password_hash($carimbo . ":" . $_SESSION['funcional'], PASSWORD_DEFAULT);
    
    $dados = compact('email', 'cf', 'jornada', 'fone', 'cidade', 'equipe', 'unidade', 'extra', 'preferencia');
    $erro = false;

    if (in_array('', $dados, true)) {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>Todos os campos devem ser preenchidos!</div>";
    } else if ($dados['jornada'] == 'Plantão' and $dados['equipe'] == 'Expediente') {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>A Equipe selecionada não confere com o Jornada de Trabalho!</div>";
    }

    // echo '<pre>';
    // var_dump("Dados: ", $dados);
    // echo '</pre>';
    // exit();
    
    if (!$erro) {
        $query = "UPDATE aep SET
                    `e-mail`=:email,
                    cf=:cf,
                    jornada=:jornada,
                    fone=:fone,
                    cidade=:cidade,
                    equipe=:equipe,
                    `lotação`=:lotacao,
                    extra=:extra,
                    preferencia=:preferencia,
                    carimbo=:carimbo,
                    codigo=:codigo WHERE funcional=:funcional";

        $resultado = $conexaoExt->query($query, [
            ':email' => $dados['email'], 
            ':cf' => $dados['cf'],
            ':jornada' => $dados['jornada'],
            ':fone' => $dados['fone'],
            ':cidade' => $dados['cidade'],
            ':equipe' => $dados['equipe'],
            ':lotacao' => $dados['unidade'],
            ':extra' => $dados['extra'],
            ':preferencia' => $dados['preferencia'],
            ':carimbo' => $carimbo,
            ':codigo' => $codigo,
            ':funcional' => $_SESSION['funcional']
        ], false);

        if ($resultado) {
            $_SESSION['e-mail'] = $dados['email'];
            $_SESSION['cf'] = $dados['cf'];
            $_SESSION['jornada'] = $dados['jornada'];
            $_SESSION['fone'] = $dados['fone'];
            $_SESSION['cidade'] = $dados['cidade'];
            $_SESSION['equipe'] = $dados['equipe'];
            $_SESSION['preferencia'] = $dados['preferencia'];
            $_SESSION['msg'] = "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>";
            header("Location: ../home.php");
            exit();
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possível cadastrar sua disponibilidade! Tente novamente mais tarde.</div>";
            header("Location: ../home.php");
        }
    } else {
        header("Location: ../perfil.php");
        exit();
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não autenticado!</div>";
    header("Location: ../index.php");
    exit();
}
?>