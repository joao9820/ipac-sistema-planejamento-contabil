<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>

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
            }, 9000)
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

        </div><!-- #END div flex - conteudo -->
        <!--
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        -->

        <!-- jquery/3.3.1 -->
        <!--<script src="<?php echo URLADM.'assets/js/jquery-3.3.1.slim.min.js'; ?>"></script>-->
        <script src="<?php echo URLADM.'assets/js/jquery.min.js'; ?>"></script>
        <!-- popper/1.14.3 -->
        <script src="<?php echo URLADM.'assets/js/popper.min.js'; ?>"></script>
        <!-- bootstrap/4.1.3 -->
        <script src="<?php echo URLADM.'assets/js/bootstrap.min.js'; ?>"></script>

        <script src="<?php echo URLADM.'assets/js/dashboard.js'; ?>"></script>
        <!-- CARREGAR USUARIOS USANDO JS -->
        <script src="<?php echo URLADM.'assets/js/usuarios.js'; ?>"></script>

    </body>
</html>