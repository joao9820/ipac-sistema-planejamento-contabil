<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:12
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}

    //var_dump($this->Dados['select']);
    //var_dump($this->Dados);

    if (isset($this->Dados['form'])) {
        $valorForm = $this->Dados['form'];
    }

    if (isset($this->Dados['form'][0])) {
        $valorForm = $this->Dados['form'][0];
    }

    if (isset($this->Dados['formDemanda'])) {
        $valorFormId = $this->Dados['formDemanda'];
    }

    if (isset($this->Dados['formDemanda'][0])) {
        $valorFormId = $this->Dados['formDemanda'][0];
    }

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Atividade</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_demanda']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-demanda/ver-demanda/'. $valorFormId['adms_demanda_id']; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar Atividades</a>
                </div>
                <?php
            }
            ?>
        </div><hr>

        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>

        <form method="post" action="" class="col-md-6">

            <input type="hidden" name="adms_demanda_id" value="<?php if (isset($valorForm['adms_demanda_id'])) { echo $valorForm['adms_demanda_id']; } ?>">
            <input type="hidden" name="id" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; } ?>">

            <div class="form-row">
                <div class="form-group col-md-10">
                    <label><span class="text-danger">* </span>Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome da demanda"
                           value="<?php if (isset($valorForm['nome'])) { echo $valorForm['nome']; } ?>">
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">* </span>Duração da Atividade</label>
                    <input name="duracao" type="time" class="form-control" placeholder=""
                           value="<?php if (isset($valorForm['duracao'])) { echo $valorForm['duracao']; } ?>">
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">* </span>Ordem</label>
                    <input name="ordem" type="number" class="form-control" placeholder=""
                           value="<?php if (isset($valorForm['ordem'])) { echo $valorForm['ordem']; } ?>">
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">* </span>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php if(isset($valorForm['descricao'])) {echo $valorForm['descricao'];}?></textarea>

                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="EditAtividade" value="Salvar" class="btn btn-outline-success">
        </form>
    </div>
</div>
