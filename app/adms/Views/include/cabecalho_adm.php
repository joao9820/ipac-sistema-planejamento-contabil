<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php
            if (isset($_SESSION['titulo'])) {
                echo $_SESSION['titulo'] . " · IPAC";
            }
            else {
                echo "IPAC";
            }
        ?>
    </title>
    <link rel="shortcut icon" href="<?php echo URLADM . 'assets/imagens/favicon.ico'; ?>" />

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/bootstrap.css">

    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/admin.css">
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/personalizado.css">
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/media.admin.css">
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/menu.css">
    
    <script defer src="<?php echo URLADM.'assets/js/fontawesome-all.min.js'; ?>"></script>
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/fontawesome.css'; ?>">
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/dashboard.css'; ?>">

</head>
<body id="page-top">