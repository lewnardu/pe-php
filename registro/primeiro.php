<?php
session_start();
ob_start();

require_once('../Database.php');
$conexao = new Database('DB_NAME_EXT');

$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
$matricula = filter_input(INPUT_POST, 'matricula', FILTER_SANITIZE_STRING);
$fone = filter_input(INPUT_POST, 'fone', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$dtnasc = filter_input(INPUT_POST, 'dtnasc', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
$rsenha = filter_input(INPUT_POST, 'rsenha', FILTER_SANITIZE_STRING);
$captcha = filter_input(INPUT_POST, 'captcha', FILTER_SANITIZE_STRING);

$dados = compact('cpf', 'nome', 'matricula', 'fone', 'email', 'dtnasc', 'senha', 'rsenha', 'captcha');
$erro = false;

if (in_array('', $dados, true)) {
    $erro = true;
    $_SESSION['msg'] = "<div class='alert alert-danger'>Todos os campos devem ser preenchidos!</div>";
} else if ($captcha != $_SESSION['captcha']) {
    $erro = true;
    $_SESSION['msg'] = "<div class='alert alert-danger'>O captch digitado não confere AQUI!</div>";
} else if (strlen($senha) < 8) {
    $erro = true;
    $_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve conter no mínimo 8 caracteres!</div>";
} else if (!ctype_alnum($senha)) {
    $erro = true;
    $_SESSION['msg'] = "<div class='alert alert-danger'>A senha deve conter apenas letras ou números.</div>";
} else if ($senha != $rsenha) {
    $erro = true;
    $_SESSION['msg'] = "<div class='alert alert-danger'>As senhas não conferem!</div>";
} else {
    $pesq_usuario = "SELECT * FROM usuarios WHERE cpf=:cpf LIMIT 1";
    $result = $conexao->query($pesq_usuario, [':cpf' => $cpf]);
    
    if ($result) {
        $res = $result[0];
        
        $pesq_usuario = "SELECT * FROM aep WHERE cpf=:cpf LIMIT 1";
        $result = $conexao->query($pesq_usuario, [':cpf' => $cpf]);
        $us = $result[0];

        if ($us['nome'] != $nome) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>O nome do servidor não confere!</div>";
        }
        if ($us['funcional'] != $matricula) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>A matrícula do servidor não confere!</div>";
        }

        $fone = preg_replace('/[^0-9]/', '', $fone);
        if ($us['fone'] != $fone) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>O telefone do servidor não confere!</div>";
        }
        if ($us['e-mail'] != $email) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>O e-mail do servidor não confere!</div>";
        }
        if ($us['dtnasc'] != $dtnasc) {
            $erro = true;
            $_SESSION['msg'] = "<div class='alert alert-danger'>A data de nascimento não confere!</div>";
        }
    } else {
        $erro = true;
        $_SESSION['msg'] = "<div class='alert alert-danger'>O CPF informado não foi encontrado!</div>";
    }
}

if (!$erro) {
    $senha = password_hash($senha, PASSWORD_DEFAULT);
    $query = "UPDATE usuarios SET senha=:senha WHERE cpf=:cpf";
    $result_usuario = $conexao->query($query, [':senha' => $senha, ':cpf' => $cpf], false);
    if ($result_usuario) {
        $_SESSION['msg'] = "<div class='alert alert-success'>Senha cadastrada com sucesso!</div>";
        header("Location: ../index.php");
        exit();
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Não foi possível cadastrar a senha!</div>";
        header("Location: ../primeiro.php");
        exit();
    }
} else {
    print_r("Erro encontrado: " . $_SESSION['msg']);
    header("Location: ../primeiro.php");
    exit();
}
?>