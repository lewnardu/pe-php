<?php
session_start();
// Configurações de segurança da sessão
ini_set('session.cookie_secure', 1); // Força o uso de cookies seguros (requer HTTPS)
ini_set('session.cookie_httponly', 1); // Evita acesso via JavaScript
ini_set('session.use_strict_mode', 1); // Impede o uso de IDs de sessão antigos

if (!empty($_SESSION['cpf'])) {
    $pageTitle = 'Início';

    $pageStyles = 'pages/partials/styles.php';

    $pageStylesCustom = '
        <link href="statics/css/pages/index.css" rel="stylesheet">';

    $pageScripts = 'pages/partials/scripts.php';

    $pageContentFile = 'pages/contents/index.php';

    require_once 'pages/partials/base.php';
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Usuario não autenticado!</div>";
    header("Location: login.php");
} 
?>