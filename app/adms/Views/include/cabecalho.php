<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<head>

    <link rel="icon" href="<?php echo URLADM . 'assets/imagens/favicon.png'; ?>">

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">


    <!-- Fonticons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">

    <title>Admin IPAC</title>

    <style>
        body {
            max-height: 100vh;
            background: #eff1f4;
            position: relative;
        }
        #login.row {
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        #header {
            min-height: 40vh;
            background-image: linear-gradient(to right, #2B2C7C, #4647C8);
        }
        #header .row {
            min-height: 40vh;
            max-height: 40vh;
            text-align: center;
        }
        #conteudo {
            min-height: 60vh;
            max-height: 60vh;
        }
        .btn-login {
            background-image: linear-gradient(to right, #2B2C7C, #4647C8);
            color: #e9e3e3;
            transition: all .2s ease-in-out;
        }
        .btn-login:hover {
            background-image: linear-gradient(to right, rgb(37, 38, 110), rgb(57, 57, 168));
            color: #FFF !important;
        }
        .form-group label {
            color: #333333;
        }

        /*ALERT COM JAVASCRIPT*/
        #mensagemCard {
            position: absolute;
            z-index: 3333;
            right: 0px;
            top: 40px;
            opacity: 0;
            transition: all .3s ease-in-out;
            box-shadow: 0 0 10px rgba(0,0,0,.5);
        }
        #mensagemCard h5.card-title {
            font-size: 1.3em;
            margin-bottom: .75rem;
        }


    </style>

</head>
<body>
<?php
    if(isset($_SESSION['msg'])){
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        $_SESSION['alert'] = "ok";
    }
?>