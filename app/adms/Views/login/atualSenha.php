
<body class="text-center">
<form class="form-signin text-center" method="POST" action="">
    <img class="mb-4 text-center" src="<?php echo URLADM.'assets/imagens/logo_login/ipac.jpg'; ?>" alt="Celke" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Atualizar a Senha</h1>

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
    <div class="form-group text-left">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" placeholder="Digite a senha">
    </div>
    <input type="submit" name="AtualSenha" class="btn btn-lg btn-warning btn-block" value="Atualizar">

    <p class="text-center">Lembrou? <a href="<?php echo URLADM . 'login/acesso' ?>" >Clique aqui</a> para acessar</p>
</form>
</body>

