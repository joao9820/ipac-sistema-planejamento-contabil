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
//var_dump($this->Dados)
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Atendimentos</h2>
            </div>
            <?php
            if ($this->Dados['botao']['arqui_atendimento']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'gerenciar-atendimento/arquivado'; ?>" class="btn btn-secondary btn-sm">Arquivados</a>
                </div>
                <?php
            }
            ?>
        </div>
        <form class="form-inline" method="POST" action="">
            <div class="form-group">
                <label>Pesquisar</label>
                <span tabindex="0" data-placement="right" data-toggle="tooltip"
                      title="Busque por: Funcionário | Cliente | Empresa ou Demanda">
                <input name="pesqAtendimento" type="text" id="pesqAtendimento" class="form-control mx-sm-3" placeholder="">
                </span>
            </div>
        </form><hr>

        <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>

        <span id="conteudoAtendimento"></span>
        
    </div>
</div>

<div class="modal fade" id="visulAtendimentoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalhes do Atendimento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span id="visul_atendimento"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>