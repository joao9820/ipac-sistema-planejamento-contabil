<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<head>

    <link rel="shortcut icon" href="<?php echo URLADM . 'assets/imagens/favicon.ico'; ?>" />

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/bootstrap.css">

    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/home.css">
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/personalizado.css">
    <link rel="stylesheet" href="<?php echo URLADM ?>assets/css/all.css">


    <title>Admin IPAC</title>

    <body id="page-top" class="body-conteudo">
    <?php
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            $_SESSION['alert'] = "ok";
        }
    ?>
        <header class="login-cabecalho">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <a href="#">
                            <img class="img-fluid  logo-login-cadastro" src="<?php echo URLADM . 'assets/imagens/logo-ipac.png' ?>" alt="IPAC">
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <section class="login-conteudo">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 mt-5 mx-auto">

                        <!-- Incluindo o conteudo -->

                    


