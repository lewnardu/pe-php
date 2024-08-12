<?php
$pageTitle = 'Eventos';

$pageStyles = 'pages/partials/styles.php';

$pageStylesCustom = '
    <link href="statics/css/pages/eventos.css" rel="stylesheet">';
    
$pageScripts = 'pages/partials/scripts.php';

$pageScriptsCustom = '
    <script src="fullcalendar-6.1.15/dist/index.global.min.js"></script>
    <script src="fullcalendar-6.1.15/packages/core/locales-all.global.min.js"></script>
    <script src="statics/js/pages/eventos.js"></script>';

$pageContentFile = 'pages/contents/eventos.php';

require_once 'pages/partials/base.php';

?>