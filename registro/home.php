<?php
session_start();
require_once('Database.php');

function fetchEvento($conexao, $id) {
    $sql = "SELECT * FROM eventos WHERE id = :valor";
    $result = $conexao->query($sql, [':valor' => $id]);
    return $result[0] ?? null;
}

if (!empty($_SESSION['cpf'])) {
    $agora = time();
    if ($agora > $_SESSION['expira']) {
        session_destroy();
        $_SESSION['msg'] = "<div class='alert alert-success'>Sessão expirada!</div>";
        header("Location: ../index.php");
        exit();
    } else {
        $conexao = new Database('DB_NAME_PLE');
        $disp = fetchEvento($conexao, 1);
    }
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não autenticado!</div>";
    header("Location: ../index.php");
    exit();
}
?>