<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 08/04/2019
 * Time: 13:27
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['listarAtenFunc']);
?>
<style>
    .table thead th {
        font-weight: 400;
    }
    .table td, .table th {
        border-top: none;
    }

</style>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'gerenciar-atendimento/listar/1'; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left"></i> Voltar</a>
                </span>
            </div>
            <div class="d-flex p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'gerenciar-atendimento/listar/1'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar atendimentos</a>
                </span>
                <span class="d-block ml-2">
                    <a href="<?php echo URLADM . 'atendimento-gerente/ver/'.$_GET['aten'].'?pg=1'; ?>"
                       class="btn btn-outline-warning btn-sm"><i class="fa fa-eye"></i> Ver atendimento</a>
                </span>
            </div>
        </div>
    </div>
    <div class="list-group-item border mx-4 mb-4 p-0 rounded">
        <div id="headerDescricaoPg" class="bg-primary">
            <h3 class="">Atendimento: <?php
                $id = $_GET['aten'];
                if ($id < 10){
                    echo "000".$id;
                } elseif ($id < 100){
                    echo "00".$id;
                } elseif ($id < 100){
                    echo "0".$id;
                } else {
                    echo $id;
                }
                ?></h3>
        </div>

        <div class="list-group-item">
            <?php
            if(isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            ?>

            <?php
                if(isset($_SESSION['msg_dia'])) {
                    echo $_SESSION['msg_dia'];
                    unset($_SESSION['msg_dia']);
                }
            ?>

            <div class="container-fluid">
                <div class="row">


                </div>
            </div>

            <div class="row">

                <div class="col-md-12 mb-4">
                    <?php
                    if (empty($this->Dados['listarAtenFunc'])) {
                        ?>

                        <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                            Nenhum funcionário definido para este atendimento!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <?php
                    } else
                    {
                        //var_dump($this->Dados['listarAtenFunc']);
                        ?>



                        <div class="table-responsive">
                            <table class="table table-striped table-hover border-0">

                                <?php
                                $contFor = 0;
                                if (!empty($this->Dados['listarAtenFunc'])) {
                                    foreach ($this->Dados['listarAtenFunc'] as $atenFunc) {
                                        extract($atenFunc);

                                        ?>
                                        <?php
                                         if ($contFor == 0){
                                        ?>
                                        <thead class="border-0">
                                        <tr>
                                            <th></th>
                                            <th class="">Funcionário</th>
                                            <th>Data/Hora para Início</th>
                                            <th class="">Departamento</th>
                                            <th class="">Atividade</th>
                                            <th class="">Duração</th>
                                            <th class="">Data Fatal</th>
                                            <th>Status</th>
                                            <th>Data Início Real</th>
                                            <th>Data Término</th>
                                            <th></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php
                                            }
                                         $contFor++;
                                        ?>

                                        <tr>
                                            <td>
                                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar atividade">
                                                    <button type="button" onclick="
                                                            Parametros('<?php echo $ativ_id; ?>' ,
                                                            '<?php echo $atividade; ?>',
                                                            '<?php echo $aten_id; ?>',
                                                            '<?php echo $dema_id; ?>',
                                                            '<?php echo $func_id; ?>',
                                                            '<?php echo $id_aten_fun; ?>',
                                                            '<?php echo $nome; ?>')
                                                            "
                                                            class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editarFuncionarioModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                </span>
                                                <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="Ver planejamento deste funcinoário para a data selecionada.">
                                                    <a href="<?php echo URLADM . 'atendimento-funcionarios/ver-planejamento/' . $dema_id. '?aten='.$aten_id.'&func='.$func_id.'&data='.$data_inicio_planejado.'&demanda='.$dema_id; ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                </span>
                                            </td>
                                            <td><?php echo $nome; ?></td>
                                            <td>
                                                <?php
                                                if (!empty($data_inicio_planejado)) {
                                                    echo date('d/m/Y', strtotime($data_inicio_planejado));
                                                    echo " as ";
                                                    echo date('H\hi', strtotime($hora_inicio_planejado));
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $departamento; ?></td>
                                            <td><?php echo $atividade; ?></td>
                                            <td><?php echo date('H:i', strtotime($duracao_atividade)); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($data_fatal)); ?></td>
                                            <td>
                                                <span class="badge badge-<?php echo $cor; ?>">
                                                    <?php echo $status; ?>
                                                </span>
                                            </td>

                                            <td>
                                                <?php
                                                if (!empty($inicio_atendimento)){
                                                    ?>
                                                    <?php echo date('d/m/Y H\hi', strtotime($inicio_atendimento)); ?>
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <td>
                                                <?php
                                                if (!empty($fim_atendimento)){
                                                ?>
                                                <?php echo date('d/m/Y H\hi', strtotime($fim_atendimento)); ?>
                                                    <?php
                                                }
                                                ?>
                                            </td>

                                            <td class="text-right">

                                                <?php
                                                    if ($sit_func == 1){
                                                ?>
                                                    <a href="<?php echo URLADM . 'atendimento-funcionarios/excluir/'.$dema_id.'?aten_id='.$aten_id.'&func_id='.$func_id.'&ativ_id='.$ativ_id.'&id_aten_fun='.$id_aten_fun; ?>" class="btn btn-outline-danger mb-2"
                                                       data-confirmDelet='Deletar?'>
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                <?php
                                                 } else {
                                                ?>
                                                <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Atendimento iniciado. Não é possível excluir o funcionário do atendimento.'>
                                                    <button class="btn btn-outline-secondary mb-2 disabled">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </span>
                                                <?php
                                                }
                                                ?>

                                            </td>
                                        </tr>

                                        <?php
                                    }
                                }
                                ?>


                                </tbody>

                            </table>

                            <?php

                            //echo $this->Dados['paginacao'];

                            ?>

                        </div>


                        <?php
                    }
                    ?>
                </div>

                <div class="col-md-5">
                    <div class="card border-light shadow mb-3" style="">
                        <div class="card-header text-primary"><i class="fas fa-user-plus"></i> Adicionar funcionário ao atendimento</div>
                        <div class="card-body">
                            <?php
                                if (empty($this->Dados['atividades'])){
                                    echo '<h5 class="card-title text-secondary bg-light p-4 rounded text-center"><i class="fas fa-exclamation-circle fa-3x" style="color: #cecece;"></i>
                                            <br>Nenhuma atividade disponível. Já foram todas selecionadas</h5>';
                                } else {
                            ?>

                            <p class="card-text">

                            <form method="post" action="" class="needs-validation" novalidate>

                                <input type="hidden" name="adms_demanda_id" value="<?php echo $this->Dados['adms_demanda_id']; ?>">
                                <input type="hidden" name="adms_atendimento_id" value="<?php echo $this->Dados['adms_atendimento_id']; ?>">


                                <div class="form-row">
                                    <div class="col-md-12">
                                        <label for="inputForm">Funcionário</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-funcionario">
                                                    <i class="fas fa-user-tie"></i>
                                                </span>
                                            </div>
                                            <select name="adms_funcionario_id" class="custom-select mr-sm-2" id="inputForm" aria-describedby="basic-funcionario" required>
                                                <option value="">Selecionar</option>
                                                <?php
                                                foreach ($this->Dados['funcionarios'] as $func){
                                                    extract($func);
                                                    echo "<option value=".$id.">$nome</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="valid-feedback">
                                                Ok
                                            </div>
                                            <div class="invalid-feedback">
                                                Selecione um funcionário
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputFormAtividade">Atividade</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-atividade">
                                                    <i class="fas fa-tasks"></i>
                                                </span>
                                            </div>
                                            <select name="adms_atividade_id" class="custom-select mr-sm-2" id="inputFormAtividade" aria-describedby="basic-atividade" required>
                                                <option value="">Selecionar</option>
                                                <?php
                                                foreach ($this->Dados['atividades'] as $ativi){
                                                    extract($ativi);
                                                    echo "<option value=".$id.">$nome</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="valid-feedback">
                                                Ok
                                            </div>
                                            <div class="invalid-feedback">
                                                Selecione uma atividade.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputFormFatal">Data Fatal</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-fatal">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="date" name="data_fatal" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="<?php echo date('Y-m-d');?>" id="inputFormFatal" class="custom-select mr-sm-2" aria-describedby="basic-fatal" required>
                                            <div class="valid-feedback">
                                                Ok
                                            </div>
                                            <div class="invalid-feedback">
                                                Defina a data fatal da atividade
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-12 mt-3 d-flex align-items-end ">
                                        <input type="hidden" name="Registrar" value="Registrar">
                                        <button class="btn btn-success" type="submit">Registrar</button>
                                    </div>

                                </div>


                            </form>

                            <?php
                            }
                            ?>

                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>




<script type="text/javascript">
    function Parametros(ativ_id, atividade, aten_id, dema_id, func_id, id_aten_fun, nome) {
        document.getElementById('nomeAtividade').innerHTML = atividade;
        document.getElementById('adms_atividade_id').value = ativ_id;
        document.getElementById('adms_demanda_id').value = dema_id;
        document.getElementById('adms_atendimento_id').value = aten_id;
        document.getElementById('funcionario_id').value = func_id;
        document.getElementById('funcionario_id').innerHTML = nome;
        document.getElementById('mesmo_func_id').value = func_id;
        document.getElementById('id_aten_fun').value = id_aten_fun;
    }
</script>

<!-- Modal -->
<div class="modal fade" id="editarFuncionarioModal" tabindex="-1" role="dialog" aria-labelledby="editandoFuncionario" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editandoFuncionario"><i class="fas fa-user-edit"></i> Editar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo URLADM . 'atendimento-funcionarios/editar'; ?>">
                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-8">
                            <h5><strong>Atividade: </strong><br/><span id="nomeAtividade"></span></h5>
                        </div>
                    </div>

                    <hr>

                    <input type="hidden" name="verificar_mesmo_funcionario" id="mesmo_func_id">
                    <input type="hidden" name="id_aten_fun" id="id_aten_fun">


                    <input type="hidden" name="adms_atividade_id" id="adms_atividade_id">
                    <input type="hidden" name="adms_demanda_id" id="adms_demanda_id">
                    <input type="hidden" name="adms_atendimento_id" id="adms_atendimento_id">

                    <div class="form-row mb-3">
                        <div class="col-md-12">
                            <label>Funcionário</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <select name="adms_funcionario_id" id="Departamento" class="form-control">
                                    <option id="funcionario_id"></option>
                                    <?php
                                    foreach ($this->Dados['funcionarios'] as $func){
                                        extract($func);
                                        echo "<option value=".$id.">$nome</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label>Atividade Prioritária</label>
                            <div class="d-flex">
                            <div class="form-check mr-4">
                                <input class="form-check-input" name="prioridade" type="radio"  id="Radios1" value="2" checked>
                                <label class="form-check-label" for="Radios1">
                                    Não
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" name="prioridade" type="radio"  id="Radios2" value="1">
                                <label class="form-check-label" for="Radios2">
                                    Sim
                                </label>
                            </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Hora de início</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <input type="time" class="form-control" placeholder="14:00">
                            </div>
                        </div>

                    </div>
                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label>Data fatal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <input type="date" class="form-control" placeholder="18/10/2019">
                            </div>
                        </div>
                    </div>

                </div>

                <input type="hidden" name="EditAtividade" value="Salvar" class="btn btn-outline-success">

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-success">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
