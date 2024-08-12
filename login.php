<?php
ob_start();
session_start();

$pageTitle = 'Login';

$pageStyles = 'pages/partials/styles.php';

$pageStylesCustom = '
    <link href="statics/css/pages/login.css" rel="stylesheet">';

$pageScripts = 'pages/partials/scripts.php';

$pageScriptsCustom = '
        <script src="js/jquery.mask.js"></script>
        <script src="statics/js/pages/mascaras.js"></script>';

$pageContentFile = 'pages/contents/login.php';

require_once 'pages/partials/base-auth.php';

ob_start();
?>