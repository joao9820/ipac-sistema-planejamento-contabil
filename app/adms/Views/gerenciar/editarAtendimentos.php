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
//var_dump($this->Dados['form'][0]);

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
                       <a href="<?php echo URLADM . 'atendimento-gerente/ver/'.$valorForm['id']; ?>" class="btn btn-primary btn-sm">Visualizar</a>
                   <?php
                   }
                   if ($this->Dados['botao']['list_atendimento']) {
                   ?>
                       <a href="<?php echo URLADM . 'gerenciar-atendimento/listar/'.$this->Dados['pg']; ?>" class="btn btn-info btn-sm">Listar Atendimentos</a>
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
                            <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/ver/'.$valorForm['id']; ?>" class="btn btn-primary btn-sm">Visualizar</a>
                        <?php
                        }
                        if ($this->Dados['botao']['list_atendimento']) {
                            ?>
                            <a class="dropdown-item" href="<?php echo URLADM . 'gerenciar-atendimento/listar/'.$this->Dados['pg']; ?>" class="btn btn-primary btn-sm">Voltar</a>
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

            <input name="id" type="hidden" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; } ?>">

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label>
                        <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="Caso esse atendimento tenha prioridade sobre outros, selecione a opção SIM.">
                            <i class="fas fa-question-circle"></i>
                        </span>
                        Prioridade
                    </label>
                    <select name="prioridade" id="prioridade" class="form-control">
                        <?php
                        if ($valorForm['prioridade'] == 1) {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1' selected>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        } elseif ($valorForm['prioridade'] == 2)  {
                            echo "<option value=''>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2' selected>Não</option>";
                        }else{
                            echo "<option value='' selected>Selecione</option>";
                            echo "<option value='1'>Sim</option>";
                            echo "<option value='2'>Não</option>";
                        }
                        ?>
                    </select>
                </div>
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
                    <select name="adms_sits_atendimento_id" id="adms_sits_atendimento_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['sitsat'] as $sitAtendimento) {
                            extract($sitAtendimento);
                            if ($valorForm['adms_sits_atendimento_id'] == $id_sits_aten) {
                                echo "<option value='$id_sits_aten' selected class='text-".$cores_sits_aten."'>$nome_sits_aten</option>";
                            } else {
                                echo "<option value='$id_sits_aten' class='text-".$cores_sits_aten."'>$nome_sits_aten</option>";
                            }
                        }
                        ?>
                    </select>

                </div>

                <div class="form-group col-md-12">
                    <label><span class="text-danger">* </span>Funcinário</label>
                    <select name="adms_funcionario_id" id="adms_funcionario_id" class="form-control">
                        <option value="">Selecione</option>
                        <?php
                        foreach ($this->Dados['select']['func'] as $funcionario) {
                            extract($funcionario);
                            if ($valorForm['adms_funcionario_id'] == $id_func) {
                                echo "<option value='$id_func' selected>$nome_func</option>";
                            } else {
                                echo "<option value='$id_func'>$nome_func</option>";
                            }
                        }
                        ?>
                    </select>

                </div>

            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="EditAtendimento" value="Salvar" class="btn btn-warning">
        </form>
    </div>
</div>
