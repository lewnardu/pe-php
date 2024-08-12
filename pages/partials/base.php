<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title><?php echo $pageTitle; ?> - Plantão Extra</title>

    <!-- Custom fonts for this template-->
    <?php 
        if ($pageStyles and file_exists($pageStyles)) {
            require_once $pageStyles;
        }
        echo $pageStylesCustom ?? '';
    ?>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require_once 'sidebar.php';?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require_once 'topbar.php';?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Content -->
                    <?php require_once $pageContentFile; ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require_once 'footerbar.php';?>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal logout -->
    <?php require_once 'modal-logout.php';?>

    <!-- Scripts -->

    <!-- Additional Page-specific scripts -->
    <?php 
        if ($pageScripts and file_exists($pageScripts)) {
            require_once $pageScripts;
        }
        echo $pageScriptsCustom ?? ''; 
    ?>

</body>

</html>