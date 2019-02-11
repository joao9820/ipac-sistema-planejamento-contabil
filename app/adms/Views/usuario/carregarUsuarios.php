<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 16:51
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['botao'])
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Usuários</h2>
            </div>

            <?php
                if ($this->Dados['botao']['cad_usuario']) {
                    ?>
                    <a href="<?php echo URLADM . 'cadastrar-usuario/cad-usuario'; ?>">
                        <div class="p-2">
                            <button class="btn btn-success btn-sm">
                                Cadastrar
                            </button>
                        </div>
                    </a>
                    <?php
                }
            ?>

        </div>
        <form class="form-inline" method="POST" action="">
            <div class="form-group">
                <label>Pesquisar</label>
                <input name="pesqUser" type="text" id="pesqUser" class="form-control mx-sm-3" placeholder="Nome ou e-mail do Usuário">
            </div>
        </form><hr>
        <?php
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
                ?>

        <span id="conteudo"></span>
    </div>
</div>

<div class="modal fade" id="visulUsuarioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalhes do Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visul_usuario"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
