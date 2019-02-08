
<body class="text-center">
<form class="form-signin text-center" method="POST" action="">
    <img class="mb-4 text-center" src="<?php echo URLADM.'assets/imagens/logo_login/ipac.jpg'; ?>" alt="Celke" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Recuperar a senha</h1>

    <?php
        //var_dump($this->Dados['form']);
        //CRIPITOGRAFAR A SENHA
        //echo password_hash("123", PASSWORD_DEFAULT);
        if(isset($_SESSION['msg'])){
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        if(isset($this->Dados['form'])){
            $valorForm = $this->Dados['form'];
        }
    ?>
    <div class="form-group">
        <label>E-mail</label>
        <input type="email" name="email" class="form-control text-left" placeholder="Digite o e-mail cadastrado" value="<?php if(isset($valorForm['email'])) {echo $valorForm['email']; } ?>">
    </div>
    <input type="submit" name="RecupUserLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Recuperar">

    <p class="text-center">Lembrou? <a href="<?php echo URLADM . 'login/acesso' ?>" >Clique aqui</a> para logar</p>
</form>
</body>

