<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/02/2019
 * Time: 13:58
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//echo $num_result ."<br>";
//echo $_SESSION['adms_empresa_id'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Página não encontrada - Erro 404</title>
    <link rel="icon" href="<?php echo URLADM.'assets/imagens/icone/favicon.png'; ?>">
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/bootstrap.min.css'; ?>">
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/signin.css'; ?>">
    <script defer src="<?php echo URLADM.'assets/js/fontawesome-all.min.js'; ?>"></script>
    <link rel="stylesheet" href="<?php echo URLADM.'assets/css/fontawesome.min.css'; ?>">

    <script src="<?php echo URLADM.'assets/js/jquery.min.js' ?>"></script>


    <link href="https://fonts.googleapis.com/css?family=Cabin:400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:900" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="<?php echo URLADM.'assets/css/erro404.css'; ?>" />


</head>
<body>
<div id="notfound" class="col-10">
    <div class="notfound">
        <h3>Oops! Página não encontrada</h3>
        <div class="notfound-404">
            <h1 class="text-secondary"><span>4</span><span>0</span><span>4</span></h1>
        </div>
        <h2 class="text-secondary">Desculpe, mas a página que você procura não foi encontrada.</h2>
        <div>
            <a class="nav-link" href="javascript:history.back()"><i class="fas fa-chevron-circle-left"></i> Voltar a página anterior</a>
        </div>
    </div>
</div>


</body>
</html>