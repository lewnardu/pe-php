<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ob_start();

require_once('Database.php');
$conexaoPle = new Database('DB_NAME_PLE');
$conexaoExt = new Database('DB_NAME_EXT');

if (!empty($_SESSION['cpf'])) {
    $query = "SELECT * FROM eventos WHERE descricao=:descricao";
    $resultado = $conexaoPle->query($query, [':descricao' => 'DISPONIBILIDADE']);
    $periodo = $resultado[0];

    $inicio = date('Y-m-d H:i:s', strtotime($periodo["disp_data_inicial"]." ".$periodo["disp_hora_inicial"]));
    $final = date('Y-m-d H:i:s', strtotime($periodo["disp_data_final"]." ".$periodo["disp_hora_final"]));
    
    $periodo_aberto = (date('Y-m-d H:i:s') >= $inicio and date('Y-m-d H:i:s') < $final) ? true : false;

    if ($periodo_aberto || $_SESSION['cfp'] == '027.761.831-27') {
        $queryUnidades = "SELECT DISTINCT nome from unidades where extra=:extra order by nome asc";
        $unidades = $conexaoPle->query($queryUnidades, [':extra' => 'sim']);

        $queryLotacoes = "SELECT DISTINCT lotação from aep where lotação<>'' order by lotação asc";
        $lotacoes = $conexaoExt->query($queryLotacoes);

        $equipes = [
            ['value' => 'Alfa', 'descricao' => 'ALFA'],
            ['value' => 'Bravo', 'descricao' => 'BRAVO'],
            ['value' => 'Charlie', 'descricao' => 'CHARLIE'],
            ['value' => 'Delta', 'descricao' => 'DELTA'],
            ['value' => 'Expediente', 'descricao' => 'EXPEDIENTE']
        ];

        $cursos_formacao = [
            ['value' => 'I', 'descricao' => 'Curso de Formação I'],
            ['value' => 'II', 'descricao' => 'Curso de Formação II'],
        ];
    } else {
        $_SESSION['msg'] = "<div class='alert alert-danger'>Período indisponível para cadastro! O período previsto é de $inicio até $final.</div>";
        header("Location: ../home.php");
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não autenticado!</div>";
    header("Location: ../index.php");
}
?>