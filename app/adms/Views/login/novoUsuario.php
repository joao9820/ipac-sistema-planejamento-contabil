
<body class="text-center">
<form class="form-signin text-left" method="POST" action="">
    <img class="mb-4 text-center" src="<?php echo URLADM.'assets/imagens/logo_login/ipac.jpg'; ?>" alt="Celke" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Novo Usuário</h1>

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
        <label>Nome</label>
        <input type="text" name="nome" class="form-control text-left" placeholder="Digite o seu nome completo" value="<?php if(isset($valorForm['nome'])) {echo $valorForm['nome']; } ?>">
    </div>
    <div class="form-group">
        <label>E-mail</label>
        <input type="email" name="email" class="form-control text-left" placeholder="Seu email" value="<?php if(isset($valorForm['email'])) {echo $valorForm['email']; } ?>">
    </div>
    <div class="form-group">
        <label>Usuário</label>
        <input type="text" name="usuario" class="form-control text-left" placeholder="Digite o seu usuario" value="<?php if(isset($valorForm['usuario'])) {echo $valorForm['usuario']; } ?>">
    </div>
    <div class="form-group">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" placeholder="Digite a senha">
    </div>
    <input type="submit" name="CadUserLogin" type="submit" class="btn btn-lg btn-success btn-block" value="Cadastrar">

    <p class="text-center"><a href="<?php echo URLADM . 'login/acesso' ?>" >Clique aqui</a> para acessar</p>
</form>
</body>

