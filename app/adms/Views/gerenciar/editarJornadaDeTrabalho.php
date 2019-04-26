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

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto py-2">
                <h2 class="display-4 titulo">Editar Funcionário</h2>
            </div>
            <?php
            if ($this->Dados['botao']['listar']) {
            ?>
            <div class="p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'jornada-de-trabalho/listar'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar Funcionários</a>
                </span>
            </div>
                <?php
            }
            ?>
        </div>

        <hr>

        <div class="d-flex mb-5">
            <div class="p-2">
                <span class="d-block">
                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Adicionar hora extra para este funcionário">
                        <a href="<?php echo URLADM . 'hora-extra/listar/1?func='. $valorForm['id']; ?>" class="btn btn-outline-success btn-sm"><i class="fas fa-plus-square"></i> Adicionar Hora Extra</a>
                    </span>
                </span>
            </div>
        </div>



        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>

        <div class="row">

            <div class="col-md-6 order-1 order-md-0">
                <form method="post" action="" >

                    <input name="id" type="hidden" value="<?php if (isset($valorForm['id'])) { echo $valorForm['id']; } ?>">


                    <div class="form-row mb-3">
                        <div class="col-md-12">
                            <label>Departamento</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <select name="adms_departamento_id" id="Departamento" class="form-control">
                                    <option>Selecione um departamento</option>
                                    <?php
                                    foreach ($this->Dados['select']['departamento'] as $departamento) {
                                        extract($departamento);
                                        if ($valorForm['adms_departamento_id'] == $id_departamento)
                                        {
                                            echo "<option value='$id_departamento' selected>$nome_departamento</option>";
                                        }
                                        else {
                                            echo "<option value='$id_departamento'>$nome_departamento</option>";
                                        }

                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="form-row">
                        <div class="col-md-12">
                            <label>Jornada de Trabalho</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-business-time"></i>
                                    </div>
                                </div>
                                <input name="jornada_de_trabalho" type="time" class="form-control"
                                       value="<?php if (isset($valorForm['jornada_de_trabalho']) and !empty($valorForm['jornada_de_trabalho'])) { echo date('H:i', strtotime($valorForm['jornada_de_trabalho'])); } ?>">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="EditFuncionario" value="Salvar" class="btn btn-outline-success">
                    <button  class="btn btn-outline-success mt-5" type="submit">Salvar</button>
                </form>
            </div>

            <div class="col-md-6 order-0 order-md-1 text-center">
                <?php
                if (isset($this->Dados['funcionarioInfo'][0])) { $funcionarioInfo = $this->Dados['funcionarioInfo'][0]; }

                if (!empty($this->Dados['funcionarioInfo'][0]) and (!empty($funcionarioInfo['imagem'])))
                {
                    echo "<img src='".URLADM."assets/imagens/usuario/".$funcionarioInfo['id']."/".$funcionarioInfo['imagem']."' class='img-fluid rounded'  width='150'  alt='".$funcionarioInfo['nome']."'> ";
                } else {
                    echo "<img src='".URLADM."assets/imagens/usuario/icone_usuario.jpg' class='img-fluid rounded'  width='150'  alt='".$_SESSION['usuario_imagem']."'> ";
                }
                ?>
                <h3 class="my-3"><?php if (isset($funcionarioInfo['nome'])) { echo $funcionarioInfo['nome']; } ?></h3>
            </div>

        </div>

    </div>
</div>