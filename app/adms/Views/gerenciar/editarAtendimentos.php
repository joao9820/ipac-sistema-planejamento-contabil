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

//var_dump($this->Dados);
//var_dump($this->Dados['form'][0]);

if (isset($this->Dados['dadosAtendimento'][0])) {
    $dadosAtendimento = $this->Dados['dadosAtendimento'][0];
}

if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}

if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Atendimento</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                   <?php
                   if ($this->Dados['botao']['vis_atendimento']) {
                       ?>
                       <a href="<?php echo URLADM . 'atendimento-gerente/ver/'.$valorForm['id']; ?>" class="btn btn-outline-primary btn-sm"><i class="far fa-eye"></i> Visualizar</a>
                   <?php
                   }
                   if ($this->Dados['botao']['list_atendimento']) {
                   ?>
                       <a href="<?php echo URLADM . 'gerenciar-atendimento/listar/'.$this->Dados['pg']; ?>" class="btn btn-outline-info btn-sm"><i class='fas fa-list'></i> Listar Atendimentos</a>
                   <?php
                   }
                   ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->Dados['botao']['vis_atendimento']) {
                            ?>
                            <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/ver/'.$valorForm['id']; ?>" class="btn btn-primary btn-sm"><i class="far fa-eye"></i> Visualizar</a>
                        <?php
                        }
                        if ($this->Dados['botao']['list_atendimento']) {
                            ?>
                            <a class="dropdown-item" href="<?php echo URLADM . 'gerenciar-atendimento/listar/'.$this->Dados['pg']; ?>" class="btn btn-primary btn-sm"><i class='fas fa-list'></i> Listar Atendimentos</a>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div><hr>

        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>

        <form method="post" action="" class="col-md-6">

            <?php
            if (isset($this->Dados['select']['descri'])) {
                extract($this->Dados['select']['descri']);
            }
            ?>

            <input name="id" type="hidden" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; } ?>">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label><span class="text-danger">* </span>Demanda</label>
                    <select name="adms_demanda_id" id="adms_demanda_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['deman'] as $demanda) {
                            extract($demanda);
                            if ($valorForm['adms_demanda_id'] == $id_demanda) {
                                echo "<option value='$id_demanda' selected>$nome_demanda</option>";
                            } else {
                                echo "<option value='$id_demanda'>$nome_demanda</option>";
                            }
                        }
                        ?>
                    </select>

                </div>
                <div class="form-group col-md-12">
                    <label><span class="text-danger">* </span>Situação do Atendimento</label>
                    <select name="adms_sits_atendimento_id" id="adms_sits_atendimento_id" class="form-control" <?php
                        if ($dadosAtendimento['situacao_funcionario'] != 2) {
                            echo "disabled";
                        }
                        ?>>
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sitsat'] as $sitAtendimento) {
                            extract($sitAtendimento);
                            if ($id_sits_aten != 2) {
                                if ($valorForm['adms_sits_atendimento_id'] == $id_sits_aten) {
                                    echo "<option value='$id_sits_aten' selected class='text-" . $cores_sits_aten . "'>$nome_sits_aten</option>";
                                } else {
                                    echo "<option value='$id_sits_aten' class='text-" . $cores_sits_aten . "'>$nome_sits_aten</option>";
                                }
                            }
                        }
                        ?>
                    </select>

                </div>

                <div class="form-group col-md-12">
                    <label>
                        <span class="text-danger">* </span> Descrição
                    </label>
                    <textarea name="descricao" id="descricao" class="form-control"><?php
                        echo $descricao_atendimento ? $descricao_atendimento : "";
                        ?></textarea>
                </div>



            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="EditAtendimento" value="Salvar" class="btn btn-outline-success">
        </form>
    </div>
</div>
