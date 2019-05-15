
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

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<!-- Optional JavaScript -->
<?php
// Quando uma sessão msg for criar e uma sessão alert for definida, então, o javascript será inserido na página para exibir a mensagem.
if(isset($_SESSION['alert'])) {
    ?>
    <script>
        var mensagemCard = document.getElementById('mensagemCard');

        // chando a função ao carregar pagina
        window.setTimeout(function () {
            fadeIn(mensagemCard, 0.5);
            fecharMensagem();
        }, 0);

        function fecharMensagem() {
            window.setTimeout(function () {
                fadeOut(mensagemCard, 1);
            }, 5000)
        }


        function fecharAgora() {
            fadeOut(mensagemCard,0.5)
        }


        // fadeIn
        function fadeIn(element,time){
            processa(element,time,0,100);
        }

        // fadeOut
        function fadeOut(element,time){
            processa(element,time,100,0);
        }

        // realizar efeito
        function processa(element,time,initial,end){
            var increment;
            var intervalo;
            var opc;

            if(initial == 0){
                increment = 2;
                element.classList.remove('d-none');
            }else {
                increment = -3;
            }

            opc = initial;

            intervalo = setInterval(function(){
                if((opc == end)){
                    if(end == 0){
                        element.classList.add('d-none');
                    }
                    clearInterval(intervalo);
                }else {
                    if (end == 0) {
                        opc += increment;
                        if (element.style.opacity >= 0) {
                            element.style.opacity = opc / 100;
                        } else {
                            element.classList.add('d-none');
                        }
                        element.style.filter = "alpha(opacity=" + opc + ")";
                        element.style.right =  -0.1 + "px";
                    } else {
                        opc += increment;
                        element.style.opacity = opc / 100;
                        element.style.filter = "alpha(opacity=" + opc + ")";
                        element.style.right = (opc - 40) + "px";
                    }
                }
            },time * 10);
        }

    </script>

    <?php
    unset($_SESSION['alert']);
}
?>

<script>

    var inputs = $('input').on('keyup', verificarInputs);
    function verificarInputs() {
        const preenchidos = inputs.get().every(({value}) => value)
        $('.btn').prop('disabled', !preenchidos);
    }

</script>

</body>
</html>


