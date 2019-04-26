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
    <link rel="icon" href="<?php echo URLADM.'assets/imagens/icone/favicon.png'; ?>">

    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/bootstrap.min.css'; ?>">
    <!--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">-->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">-->
    <script defer src="<?php echo URLADM.'assets/js/fontawesome-all.min.js'; ?>"></script>
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/fontawesome.css'; ?>">
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/dashboard.css'; ?>">

</head>
<body>