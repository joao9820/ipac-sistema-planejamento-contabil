
<body class="text-center">
<form class="form-signin" method="POST" action="">
    <img class="mb-4" src="<?php echo URLADM.'assets/imagens/logo_login/ipac.jpg'; ?>" alt="Celke" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Área Restrita</h1>

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
        <label>Usuário</label>
        <input type="text"name="usuario" class="form-control text-left" placeholder="Digite o usuário" value="<?php if(isset($valorForm['usuario'])) {echo $valorForm['usuario']; } ?>" autofocus>
    </div>
    <div class="form-group">
        <label>Senha</label>
        <input type="password" name="senha" class="form-control" placeholder="Digite a senha">
    </div>
    <input type="submit" name="SendLogin" type="submit" class="btn btn-lg btn-primary btn-block" value="Acessar">

    <p class="text-center"><a href="<?php echo URLADM . 'novo-usuario/novo-usuario' ?>" >Cadastrar</a> -
        <a href="<?php echo URLADM . 'esqueceu-senha/esqueceu-senha' ?>" >Esqueceu a senha?</a></p>
</form>

<script>

    var inputs = $('input').on('keyup', verificarInputs);
    function verificarInputs() {
        const preenchidos = inputs.get().every(({value}) => value)
        $('.btn').prop('disabled', !preenchidos);
    }

</script>
</body>

