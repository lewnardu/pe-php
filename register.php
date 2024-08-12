<?php
ob_start();
session_start();

$pageTitle = 'Primeiro Acesso';

$pageStyles = 'pages/partials/styles.php';

$pageStylesCustom = '
    <link href="statics/css/pages/login.css" rel="stylesheet">';

$pageScripts = 'pages/partials/scripts.php';

$pageContentFile = 'pages/contents/register.php';

require_once 'pages/partials/base-auth.php';

ob_start();
?>