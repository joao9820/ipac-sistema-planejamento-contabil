
<div id="login" class="row flex-column justify-content-center align-itens-center">
    <div id="header">
        <div class="container">
            <div class="row justify-content-center align-items-end">
                <div class="col-12 py-5 text-light">
                    <!-- <img class="mb-4" src="<?php echo URLADM.'assets/imagens/logo_login/ipac.jpg'; ?>" alt="Celke" height="72"> -->
                    <h1 class="mb-0 d-inline-block">SISTEMA IPAC</h1>
                </div>
            </div>
        </div>
    </div>
    <div id="conteudo">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 mt-4 mt-md-0 my-md-5">

                    <form method="POST" action="">

                        <?php
                        if (isset($_SESSION['msg'])) {
                            echo $_SESSION['msg'];
                            unset($_SESSION['msg']);
                        }
                        if (isset($this->Dados['form'])) {
                            $valorForm = $this->Dados['form'];
                        }
                        ?>

                        <div class="form-group">
                            <label for="usuario"><i class="fas fa-user"></i> Usuário</label>
                            <input name="usuario" type="text" class="form-control" id="usuario" aria-describedby="emailHelp" placeholder="Seu usuário" required value="<?php if (isset($valorForm['usuario'])) {
                                echo $valorForm['usuario'];
                            } ?>">
                        </div>
                        <div class="form-group">
                            <label for="senha"><i class="fas fa-fingerprint"></i> Senha</label>
                            <input name="senha" type="password" class="form-control" id="senha" placeholder="Senha" required>
                        </div>

                        <input name="SendLogin" type="submit" class="btn btn-lg btn-login btn-block my-4 my-md-5" value="Entrar">
                        <p class="text-center">
                            <a class="nav-link" href="<?php echo URLADM . 'novo-usuario/novo-usuario' ?>">Cadastre-se</a>
                        </p>
                        <p class="text-center">
                            <a class="nav-link" href="<?php echo URLADM . 'esqueceu-senha/esqueceu-senha' ?>">Esqueceu a senha?</a>
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>


<!-- Optional JavaScript -->

<script>

    var inputs = $('input').on('keyup', verificarInputs);
    function verificarInputs() {
        const preenchidos = inputs.get().every(({value}) => value)
        $('.btn').prop('disabled', !preenchidos);
    }

</script>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>


