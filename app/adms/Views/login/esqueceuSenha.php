
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
                    <form class="form-signin text-center" method="POST" action="">
                        <img class="mb-4 text-center" src="<?php echo URLADM.'assets/imagens/logo_login/ipac.jpg'; ?>" alt="Celke" height="72">
                        <h1 class="h3 mb-3 font-weight-normal">Recuperar a senha</h1>

                        <?php
                            //var_dump($this->Dados['form']);
                            //CRIPITOGRAFAR A SENHA
                            //echo password_hash("123", PASSWORD_DEFAULT);
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