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
//var_dump($this->Dados);

?>
<style>
    .planejamento_i_t .badge {
        font-size: 1em;
        font-weight: 400;
        text-shadow: 1px 1px 10px rgba(0,0,0,.8);
        transition: all .2s;
    }
    .planejamento_i_t .badge:hover {
        text-shadow: 1px 1px 10px rgba(255,255,255,.8);
    }
    .btn-sm {
        min-width: 40px ;
    }
</style>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Gerenciar Funcionários</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_usuario'])
            {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-usuario/cad-usuario'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-user-plus"></i> Cadastrar Funcionário
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
            <a href="<?php echo URLADM . 'departamentos/listar'; ?>">
                <div class="p-2">
                    <button class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-table"></i> Listar Departamentos
                    </button>
                </div>
            </a>
        </div>

        <?php
            if (empty($this->Dados['listFuncionarios']))
            {
                ?>

                <div class="alert alert-secondary text-center alert-dismissible fade show" role="alert">
                    <i class="fas fa-user-tie fa-6x my-3 text-secondary"></i>
                    <h5 class="text-secondary">Nenhum funcionário encontrado!</h5>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php
            } else {
                if (isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }
        ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="bg-info text-light">
                <tr>
                    <th>Planejamento</th>
                    <th scope="col" class="">Funcionário</th>
                    <th scope="col" class="d-none d-lg-table-cell">Departamento</th>
                    <th scope="col" class="d-none d-lg-table-cell">Jornada de Trabalho</th>
                    <th scope="col" class="d-none d-lg-table-cell">Hora Extra / Data</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
                </thead>

                <tbody>
                <?php

                foreach ($this->Dados['listFuncionarios'] as $funcionario)
                {
                    extract($funcionario);
                    ?>
                    <tr>
                        <td>
                            <a href="<?php echo URLADM . 'atendimentos/listar/1?func='. $id; ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                        </td>
                        <td scope="row"><?php echo $nome; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $departamento; ?></td>
                        <td class="planejamento_i_t ">
                            <?php
                                if (isset($hora_inicio, $hora_inicio2)) {
                                    ?>
                                    <span class="d-flex justify-content-start">
                                <span class="badge badge-secondary mr-1">
                                     <?php
                                     echo date('H:i', strtotime($hora_inicio));
                                     ?>
                                </span>
                                <span class="badge badge-secondary">
                                    <?php
                                    echo date('H:i', strtotime($hora_termino));
                                    ?>
                                </span>
                            </span>
                                    <span class="d-flex justify-content-start mt-1">
                                <span class="badge badge-secondary mr-1">
                                     <?php
                                     echo date('H:i', strtotime($hora_inicio2));
                                     ?>
                                </span>
                                <span class="badge badge-secondary">
                                    <?php
                                    echo date('H:i', strtotime($hora_termino2));
                                    ?>
                                </span>
                            </span>
                                    <?php
                                } else {
                                    ?>
                            Não registrada
                                    <?php
                                }
                            ?>
                        </td>
                        <td>
                            <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Gerenciar hora extra para esse funcionário">
                                <a href="<?php echo URLADM . 'hora-extra/listar/1?func='. $id; ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user-clock"></i>
                                </a>
                            </span>
                        </td>



                        <td class="text-center">
                            <span class="d-none d-md-block">

                                <?php
                                if ($this->Dados['botao']['editar_jornada'])
                                {
                                    ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar departamento">
                                    <button type="button" onclick="
                                            Parametros('<?php echo $id; ?>' ,
                                            '<?php echo $nome; ?>',
                                            '<?php echo $email; ?>',
                                            '<?php if (!empty($imagem)){ echo $imagem;} else {echo "icone_usuario.jpg";} ?>',
                                            '<?php echo URLADM; ?>')
                                            "
                                            class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#editarFuncionarioModal">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    </span>
                                    <?php
                                }
                                if (!isset($hora_inicio)){
                                ?>
                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Registrar Jornada de trabalho">
                                    <button type="button" onclick="Registrar('<?php echo $id; ?>' ,
                                            '<?php echo $nome; ?>',
                                            '<?php if (!empty($imagem)){ echo $imagem;} else {echo "icone_usuario.jpg";} ?>',
                                            '<?php echo URLADM; ?>')" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editarJornadaModal">
                                        <i class="fas fa-plus-square"></i>
                                    </button>
                                </span>
                                <?php
                                }
                                if (isset($hora_inicio)){
                                ?>
                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Atualizar Jornada de trabalho">
                                    <button type="button" onclick="AtualizarJornada('<?php echo $id; ?>' ,
                                            '<?php echo $nome; ?>',
                                            '<?php if (!empty($imagem)){ echo $imagem;} else {echo "icone_usuario.jpg";} ?>',
                                            '<?php echo URLADM; ?>',
                                            '<?php echo date('H:i', strtotime($hora_inicio)); ?>',
                                            '<?php echo date('H:i', strtotime($hora_termino)); ?>',
                                            '<?php echo date('H:i', strtotime($hora_inicio2)); ?>',
                                            '<?php echo date('H:i', strtotime($hora_termino2)); ?>')" class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#atualizarJornadaModal">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                </span>
                                <?php
                                }
                                ?>
                            </span>
                        </td>
                    </tr>

                    <?php
                }
                ?>


                </tbody>

            </table>

            <?php

            //echo $this->Dados['paginacao'];
            } // Fim do else para verificar se tem dados para exibir
            ?>

        </div>
    </div>
</div>
<?php
$teste = 12;
?>

<script type="text/javascript">
    function Parametros(id, funcionario, email, imagem, URLADM) {
        let urlImagem;
        if (imagem === "icone_usuario.jpg") {
            urlImagem = "<img  class='img-fluid rounded'  width='150' src='"+URLADM+"assets/imagens/usuario/"+imagem+"'>";
        } else {
            urlImagem = "<img class='img-fluid rounded'  width='150' src='"+URLADM+"assets/imagens/usuario/"+id+"/"+imagem+"'>";
        }
        document.getElementById('idFunc').value = id;
        document.getElementById('nomeFunc').innerHTML = funcionario;
        document.getElementById('emailFunc').innerHTML = email;
        document.getElementById('imagemFunc').innerHTML = urlImagem;
    }
</script>
<!-- Modal -->
<div class="modal fade" id="editarFuncionarioModal" tabindex="-1" role="dialog" aria-labelledby="editandoFuncionario" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editandoFuncionario"><i class="fas fa-user-edit"></i> Editar Funcionário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo URLADM . 'editar-jornada-de-trabalho/editar/'.$teste; ?>">
                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-4">
                            <span id="imagemFunc"></span>
                        </div>
                        <div class="col-8">
                            <h5 id="nomeFunc"></h5>
                            <p id="emailFunc"></p>
                        </div>
                    </div>

                    <hr>


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
                                    <option value="">Selecionar...</option>
                                    <option value="1">Contábil</option>
                                    <option value="2">Fiscal</option>
                                    <option value="3">Folha</option>
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>

                </div>

                <input id="idFunc" name="id" type="hidden">
                <input type="hidden" name="EditFuncionario" value="Salvar" class="btn btn-outline-success">

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-outline-success">Atualizar</button>
            </div>
            </form>
        </div>
    </div>
</div>






<script type="text/javascript">
    function Registrar(id, funcionario, imagem, URLADM) {
        let urlImagem;
        if (imagem === "icone_usuario.jpg") {
            urlImagem = "<img  class='img-fluid rounded'  width='150' src='"+URLADM+"assets/imagens/usuario/"+imagem+"'>";
        } else {
            urlImagem = "<img class='img-fluid rounded'  width='150' src='"+URLADM+"assets/imagens/usuario/"+id+"/"+imagem+"'>";
        }
        document.getElementById('idFuncR').value = id;
        document.getElementById('nomeFuncR').innerHTML = funcionario;
        document.getElementById('imagemFuncR').innerHTML = urlImagem;
    }
</script>
<!-- Modal -->
<div class="modal fade" id="editarJornadaModal" tabindex="-1" role="dialog" aria-labelledby="editandoJornada" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editandoJornada"><i class="fas fa-business-time"></i> Definir Jornada de Trabalho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo URLADM . 'planejamento/editar/' ?>">
                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-4">
                            <span id="imagemFuncR"></span>
                        </div>
                        <div class="col-8">
                            <h5 id="nomeFuncR"></h5>
                        </div>
                    </div>

                    <hr>

                    <input type="hidden" name="adms_funcionario_id" id="idFuncR">

                    <fieldset>
                        <legend>Período da manhã:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio">Início</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de início dos atendimentos.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="time" name="hora_inicio" class="form-control" required>
                                    </div>
                                </span>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino">Término</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de para e iniciar o intervalo.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino" type="time" class="form-control" required>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Período da tarde:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio2">Início</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de retomar os atendimentos.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="time" name="hora_inicio2" class="form-control" required>
                                    </div>
                                </span>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino2">Término</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de encerrar as atividades.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino2" type="time" class="form-control" required>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <input type="hidden" name="RegistrarPlanejamento" value="Salvar" class="btn btn-outline-success">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-success">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script type="text/javascript">
    function AtualizarJornada(id, funcionario, imagem, URLADM, ahora_inicio, ahora_termino, ahora_inicio2, ahora_termino2) {
        let urlImagem;
        if (imagem === "icone_usuario.jpg") {
            urlImagem = "<img alt='' class='img-fluid rounded'  width='150' src='"+URLADM+"assets/imagens/usuario/"+imagem+"'>";
        } else {
            urlImagem = "<img alt='' class='img-fluid rounded'  width='150' src='"+URLADM+"assets/imagens/usuario/"+id+"/"+imagem+"'>";
        }
        document.getElementById('idFuncA').value = id;
        document.getElementById('nomeFuncA').innerHTML = funcionario;
        document.getElementById('imagemFuncA').innerHTML = urlImagem;

        document.getElementById('hora_inicio').value = ahora_inicio;
        document.getElementById('hora_termino').value = ahora_termino;
        document.getElementById('hora_inicio2').value = ahora_inicio2;
        document.getElementById('hora_termino2').value = ahora_termino2;

    }
</script>

<!-- Modal -->
<div class="modal fade" id="atualizarJornadaModal" tabindex="-1" role="dialog" aria-labelledby="atualizarJornada" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="atualizarJornada"><i class="fas fa-user-edit"></i> Atualizar Jornada de Trabalho</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="<?php echo URLADM . 'planejamento/editar/' ?>">
                <div class="modal-body">

                    <div class="row mb-4">
                        <div class="col-4">
                            <span id="imagemFuncA"></span>
                        </div>
                        <div class="col-8">
                            <h5 id="nomeFuncA"></h5>
                        </div>
                    </div>

                    <hr>

                    <input type="hidden" name="adms_funcionario_id" id="idFuncA">

                    <fieldset>
                        <legend>Período da manhã:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio">Início</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de início dos atendimentos.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="time" name="hora_inicio" id="hora_inicio" class="form-control">
                                    </div>
                                </span>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino">Término</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de para e iniciar o intervalo.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <label for="ahora_termino"></label><input name="hora_termino" type="time" id="hora_termino" class="form-control">
                                    </div>
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Período da tarde:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio2">Início</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de retomar os atendimentos.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="time" name="hora_inicio2" id="hora_inicio2" class="form-control">
                                    </div>
                                </span>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino2">Término</label>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina a hora de encerrar as atividades.">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino2" type="time" id="hora_termino2" class="form-control">
                                    </div>
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <input type="hidden" name="EditPlanejamento" value="Salvar" class="btn btn-outline-success">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-success">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>