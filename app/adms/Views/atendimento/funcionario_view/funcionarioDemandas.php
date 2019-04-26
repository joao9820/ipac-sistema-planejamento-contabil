<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//echo $_SESSION['adms_empresa_id'];
//var_dump($this->Dados);
extract($this->Dados['jornadaDeTrabalho']);
//echo $hora_extra;
?>
<style>

    .planejamento_i_t .badge {
        font-size: 1em;
        font-weight: 400;
        text-shadow: 1px 1px 10px rgba(0,0,0,.8);
        transition: all .2s;
    }
    .no-shadow {
        text-shadow: none !important;
    }
    .planejamento_i_t .badge:hover {
        text-shadow: 1px 1px 10px rgba(255,255,255,.8);
    }
    #horaExtraTotal {
        max-width: 100px;
    }
    .btnOpcoes {
        min-width: 80px;
    }
    .btnOpcoesDisabled {
        opacity: .5 !important;
    }
    .text-transparente {
        color: transparent;
        background: transparent;
        border: transparent;
    }
</style>
<div class="content p-1">



    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Atendimentos</h2>
            </div>
        </div>
    </div>



    <?php
        //var_dump($this->Dados['planejamento']);
        if($this->Dados['planejamento']){
            extract($this->Dados['planejamento']);
            if (!empty($hora_extra)) {
                $extraa = explode(':', $hora_extra);
                $data = new DateTime(date('H:i', strtotime($hora_termino2)));
                $data->modify('+' . $extraa[0] . ' hours');
                $data->modify('+' . $extraa[1] . ' minutes');
                $hora_termino2 = $data->format('H:i');
                //echo $hora_termino2;
            }
        }
        /*
        echo $hora_inicio;
        echo $hora_termino;
        echo $hora_inicio2;
        echo $hora_termino2;
        */
    ?>
    <span class="d-block my-3 ml-4">
        <button onclick="Parametros('<?php echo $hora_inicio; ?>', '<?php echo $hora_termino; ?>', '<?php echo $hora_inicio2; ?>', '<?php echo $hora_termino2; ?>', '<?php echo $adms_funcionario_id; ?>')"
                class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#editarFuncionarioModal">
            <i class="fa fa-eye"></i> Ver Planejamento
        </button>
    </span>
    <div class="list-group-item border mx-4 mb-4 p-0 rounded">
        <div id="headerDescricaoPg" class="bg-primary">
            <h3 class="">Atendimentos Pendente</h3>
        </div>

        <div class="list-group-item">
            <?php
            if(isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 p-0">
                        <form method="post" action="" class="form-inline">
                            <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="Hora extra hoje">
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-stopwatch"></i>
                                        </div>
                                    </div>
                                    <input name="total" type="text" class="form-control" id="horaExtraTotal" value="<?php
                                        if (!empty($hora_extra)) {
                                            echo date('h\hi', strtotime($hora_extra));
                                        } else {
                                            echo "00h00";
                                        }
                                    ?>" disabled>
                                </div>
                            </span>
                        </form>
                    </div>
                </div>
            </div>
            <hr>

            <?php
                if (!empty($this->Dados['listarAtendimentosInterrompido'])){
            ?>
            <h4 class="text-secondary mr-2">Aguardando: </h4>
            <div class="table-responsive col-md-8 px-0">
                <table class="table table-striped table-hover table-border">
                    <thead class="bg-info text-light">
                    <tr class="text-center">
                        <th class="">Atividades</th>
                        <th class="">Status</th>
                        <th class="">Cliente</th>
                        <th class="" tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data e hora da solicitação">
                            Data
                        </th>
                        <th class="">Ações</th>
                    </tr>
                    </thead>
                    <?php
                    foreach ($this->Dados['listarAtendimentosInterrompido'] as $interrompido) {
                        extract($interrompido);
                        ?>
                        <tr class="text-warning">
                            <td>
                                 <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Demanda: <?php echo $demanda; ?>'>
                                    <?php echo $nome_atividade; ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-<?php echo $cor ?>">
                                    <?php echo $nome_situacao; ?>
                                </span>
                            </td>
                            <td>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo ucwords(strtolower($nome_empresa)); ?>">
                                    <?php
                                    echo strtoupper($fantasia_empresa);
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    echo date('H\hi - d/m/Y', strtotime($created));
                                ?>
                            </td>
                            <td>
                                <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para continuar o atendimento.'>
                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status=3&pg='.$this->Dados['pg']; ?>" class="btn btn-outline-info btn-sm mb-2 btnOpcoes"
                                       data-sitAtenContinuar='Tem certeza que deseja da continuidade ao atendimento agora?'>
                                        Continuar
                                    </a>
                                </span>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <hr>
            <?php
            }
            ?>


            <h4 class="text-secondary mr-2">Últimos: </h4>
            <?php
            if (empty($this->Dados['listarAtendimentos'])) {
                ?>

                <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                    Nenhum atendimento a ser listado!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php
            } else
            {

                ?>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-border">
                        <thead class="bg-info text-light">
                        <tr class="text-center">
                            <th class="">Opções</th>
                            <th class="">Atividades</th>
                            <th class="">Duração</th>
                            <th class="">
                                <span class="d-block text-center border-bottom pb-1 mb-1">Planejamento</span>
                                <div class="d-flex justify-content-between">
                                    <span>Inicio</span>
                                    <span>Términio</span>
                                </div>
                            </th>
                            <th class="">Tempo Restante</th>
                            <th class="">Status</th>
                            <th class="">Cliente</th>
                            <th class="" tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data e hora da solicitação">
                                Data
                            </th>
                            <th class="">Ações</th>
                        </tr>
                        <tr>

                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        // Listar atendimentos
                            // Temporario para exibir luz de aviso
                            $contLuz = 0;

                            // Criando variaveis de controle do planejamento
                            $inicio_cp = null;
                            $termino_cp = null;
                            $inicio_cp_2 = null;
                            $termino_cp_2 = null;
                            $inicio_cp_3 = null;
                            $termino_cp_3 = null;

                            $hora_inicio3 = $hora_inicio;

                            foreach ($this->Dados['listarAtendimentos'] as $atendimento){
                                extract($atendimento);
                        ?>
                        <tr class="text-center">
                            <td>
                                <?php
                                $contLuz++;
                                    if ( !empty($data_fatal) and (date('Y-m-d', strtotime($data_fatal)) == date('Y-m-d'))){
                                ?>
                                <span class="text-warning" tabindex='0' data-placement='top' data-toggle='tooltip' title='Aviso! A data limite para concluir o atendimento é hoje.'>
                                    <i class="fas fa-circle"></i>
                                </span>
                                <?php
                                    } elseif ( !empty($data_fatal) and (date('Y-m-d', strtotime($data_fatal)) < date('Y-m-d'))){
                                ?>
                                <span class="text-danger" tabindex='0' data-placement='top' data-toggle='tooltip' title='Atenção! Atendimento ultrapassou a data limite de entrega.'>
                                    <i class="fas fa-circle"></i>
                                </span>
                                <?php
                                } else {
                                ?>
                                <span class="text-transparente">
                                    <i class="fas fa-circle"></i>
                                </span>
                                <?php
                                }
                                if ($id_sits_aten_func == 1) {
                                    // Não iniciado
                                    ?>
                                    <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
                                        <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']. '&aten='.$id_atendimento; ?>" class="btn btn-outline-success btn-sm mb-2 btnOpcoes"  data-sitAtenIniciar='Tem certeza que deseja iniciar o atendimento?'>
                                            Iniciar
                                        </a>
                                    </span>
                                    <a href="#" class="btn btn-secondary btn-sm mb-2 btnOpcoesDisabled disabled">
                                        Pausar
                                    </a>
                                    <?php
                                } elseif ($id_sits_aten_func == 2){
                                    // Iniciado
                                    ?>
                                    <a href="#" class="btn btn-secondary btn-sm mb-2 btnOpcoesDisabled disabled">
                                        Continuar
                                    </a>
                                    <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para pausar o atendimento.'>
                                        <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']. '&aten='.$id_atendimento; ?>" class="btn btn-outline-warning btn-sm mb-2" data-sitAtenPausar='Tem certeza que deseja pausar o atendimento?'>
                                            Pausar
                                        </a>
                                    </span>
                                    <?php
                                } elseif ($id_sits_aten_func == 3) {
                                    // Pausado
                                    ?>
                                    <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para continuar o atendimento.'>
                                        <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']. '&aten='.$id_atendimento; ?>" class="btn btn-outline-info btn-sm mb-2 btnOpcoes"
                                           data-sitAtenContinuar='Tem certeza que deseja da continuidade ao atendimento agora?'>
                                            Continuar
                                        </a>
                                    </span>
                                    <a href="#" class="btn btn-secondary btn-sm mb-2 btnOpcoesDisabled disabled">
                                        Pausar
                                    </a>
                                    <?php
                                } else {
                                    // Finalizado
                                    ?>
                                    <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Atendimento finalizado.'>
                                        <a href="#" class="btn btn-dark btn-sm mb-2 btnOpcoes btnOpcoesDisabled disabled">
                                            Finalizado
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Descrição: <?php echo $descricao_atividade; ?>'>
                                    <?php echo $nome_atividade; ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    echo date('H\hi', strtotime($duracao_atividade));
                                ?>
                            </td>
                            <td class="planejamento_i_t d-flex flex-column justify-content-between">
                                <?php
                                    if ($inicio_cp_2 == null) {
                                ?>
                                <span class="d-flex justify-content-between">
                                    <span id="horaInicioCp" class="badge badge-secondary">
                                        <?php
                                        if ($termino_cp == null) {
                                            echo date('H:i', strtotime($hora_inicio));
                                        } else {
                                            echo date('H:i', strtotime($termino_cp));
                                            $hora_inicio = date('H:i', strtotime($termino_cp));
                                        }
                                        ?>
                                    </span>
                                    <span id="horaTerminoCp" class="badge badge-secondary">
                                        <?php
                                        $help = explode(':', $duracao_atividade);
                                        $data = new DateTime(date('H:i', strtotime($hora_inicio)));
                                        $data->modify('+' . $help[0] . ' hours');
                                        $data->modify('+' . $help[1] . ' minutes');

                                        if (($data->format('H:i') <= date('H:i', strtotime($hora_termino)))) {
                                            echo $data->format('H:i');
                                        } else {
                                            $intervalo = gmdate('H:i:s', strtotime($data->format('H:i')) - strtotime($hora_termino) );

                                            echo date('H:i', strtotime($hora_termino));

                                        }

                                        $termino_cp = $data->format('H:i');
                                        ?>
                                    </span>
                                </span>
                                        <?php
                                        if (isset($intervalo)){
                                            echo '<span class="d-flex justify-content-between mt-1">';
                                                echo '<span id="horaInicioCp" class="badge badge-secondary">';
                                                echo date('H:i', strtotime($hora_inicio2));
                                                echo '</span>';

                                                echo '<span id="horaInicioCp" class="badge badge-secondary">';
                                                $help = explode(':', $intervalo);
                                                $data = new DateTime(date('H:i', strtotime($hora_inicio2)));
                                                $data->modify('+' . $help[0] . ' hours');
                                                $data->modify('+' . $help[1] . ' minutes');
                                                    echo $data->format('H:i');
                                                echo '</span>';
                                            echo '</span>';

                                            $inicio_cp_2 = $data->format('H:i');
                                        }
                                        ?>
                                    <?php

                                } else if ($inicio_cp_3 == null) {

                                    ?>
                                <span class="d-flex justify-content-between">
                                    <span id="horaInicioCp" class="badge badge-secondary">
                                        <?php
                                        if ($termino_cp_2 == null) {
                                            echo date('H:i', strtotime($inicio_cp_2));
                                        } else {
                                            echo date('H:i', strtotime($termino_cp_2));
                                            $inicio_cp_2 = date('H:i', strtotime($termino_cp_2));
                                        }
                                        ?>
                                    </span>
                                    <span id="horaTerminoCp" class="badge badge-secondary">
                                        <?php
                                        $help = explode(':', $duracao_atividade);
                                        $data = new DateTime(date('H:i', strtotime($inicio_cp_2)));
                                        $data->modify('+' . $help[0] . ' hours');
                                        $data->modify('+' . $help[1] . ' minutes');
                                        //echo $data->format('H:i');

                                        if (($data->format('H:i') <= date('H:i', strtotime($hora_termino2)))) {
                                            echo $data->format('H:i');
                                        } else {
                                            $intervalo2 = gmdate('H:i', strtotime($data->format('H:i')) - strtotime($hora_termino2) );

                                            echo date('H:i', strtotime($hora_termino2));

                                        }

                                        $termino_cp_2 = $data->format('H:i');
                                        //echo $termino_cp;
                                        ?>
                                    </span>
                                </span>

                                        <?php
                                        if (isset($intervalo2)){
                                            //echo $intervalo2;
                                            echo '<span class="d-flex justify-content-between mt-1">';
                                            echo '<span id="horaInicioCp" class="badge badge-light no-shadow">';
                                            echo date('H:i', strtotime($hora_inicio3));
                                            echo '</span>';

                                            echo '<span id="horaInicioCp" class="badge badge-light no-shadow">';
                                            $help = explode(':', $intervalo2);
                                            $data = new DateTime(date('H:i', strtotime($hora_inicio3)));
                                            $data->modify('+' . $help[0] . ' hours');
                                            $data->modify('+' . $help[1] . ' minutes');
                                                echo $data->format('H:i');
                                            echo '</span>';
                                            echo '</span>';

                                            $inicio_cp_3 = $data->format('H:i');
                                        }
                                        ?>

                                <?php
                                    } else {
                                        ?>
                                        <span class="d-flex justify-content-between">
                                            <span id="horaInicioCp" class="badge badge-light no-shadow">
                                                <?php
                                                if ($termino_cp_3 == null) {
                                                    echo date('H:i', strtotime($inicio_cp_3));
                                                } else {
                                                    echo date('H:i', strtotime($termino_cp_3));
                                                    $inicio_cp_3 = date('H:i', strtotime($termino_cp_3));
                                                }
                                                ?>
                                            </span>
                                            <span id="horaTerminoCp" class="badge badge-light no-shadow">
                                                <?php
                                                $help = explode(':', $duracao_atividade);
                                                $data = new DateTime(date('H:i', strtotime($inicio_cp_3)));
                                                $data->modify('+' . $help[0] . ' hours');
                                                $data->modify('+' . $help[1] . ' minutes');
                                                echo $data->format('H:i');
                                                $termino_cp_3 = $data->format('H:i');
                                                //echo $termino_cp;
                                                ?>
                                            </span>
                                        </span>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td>
                                <!-- Calculo para exibir o tempo restante -->
                                <?php
                                    if ($id_sits_aten_func == 1) {
                                        echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Esse atendimento ainda não foi iniciado">--:--</span>';
                                        //echo "--:--";
                                    } elseif ($id_sits_aten_func == 3){

                                        echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos">';

                                        if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {
                                            if (date('H:i', strtotime($at_tempo_restante)) < date('H:i', strtotime('01:00'))){
                                                echo date('i\m', strtotime($at_tempo_restante));
                                            } else {
                                                echo date('H\hi', strtotime($at_tempo_restante));
                                            }
                                        }
                                        elseif (!empty($at_tempo_excedido)) {

                                            echo "<span id='sessao' class='text-danger'>";
                                            echo "-".date('H\hi', strtotime($at_tempo_excedido));
                                            echo "</span>";

                                        } else {
                                            echo "--:--";
                                        }

                                        echo '</span>';


                                    } elseif ($id_sits_aten_func == 2) {

                                        if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {

                                            // Pegando a hora restante do atendimento no banco e transformando em segundos
                                            $at_iniciado = date('Y-m-d H:i:s', strtotime($at_iniciado));
                                            $partes = explode(':', $at_tempo_restante);
                                            $segundosTotal = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                            // Pegando a hora do banco em que foi iniciado o atendimento
                                            $at_pausado = date('Y-m-d H:i:s');
                                            $dteStart = new DateTime($at_iniciado);
                                            $dteEnd = new DateTime($at_pausado);
                                            $dteDiff = $dteStart->diff($dteEnd);
                                            $horas_diferenca = $dteDiff->format('%H');
                                            $minutos_diferenca = $dteDiff->format('%i');
                                            $segundos_diferenca = $dteDiff->format('%s');
                                            $segundosAndamento = $horas_diferenca * 3600 + $minutos_diferenca * 60 + $segundos_diferenca;

                                            $tempo_restanteUrgente = $segundosTotal - $segundosAndamento;

                                            echo "<span id='sessaoUrgente' class='text-primary'></span>";

                                            $valorControler = 0;

                                        } elseif (!empty($at_tempo_excedido)){

                                            echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Atendimento atrasado!">';

                                            // Pegando a hora restante do atendimento no banco e transformando em segundos
                                            $at_iniciado = date('Y-m-d H:i:s', strtotime($at_iniciado));
                                            $partes = explode(':', $at_tempo_excedido);
                                            $segundosTotal = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                            // Pegando a hora do banco em que foi iniciado o atendimento
                                            $at_pausado = date('Y-m-d H:i:s');
                                            $dteStart = new DateTime($at_iniciado);
                                            $dteEnd = new DateTime($at_pausado);
                                            $dteDiff = $dteStart->diff($dteEnd);
                                            $horas_diferenca = $dteDiff->format('%H');
                                            $minutos_diferenca = $dteDiff->format('%i');
                                            $segundos_diferenca = $dteDiff->format('%s');
                                            $segundosAndamento = $horas_diferenca * 3600 + $minutos_diferenca * 60 + $segundos_diferenca;

                                            $tempo_restanteUrgente = $segundosTotal + $segundosAndamento;

                                            echo "<span id='sessaoUrgente' class='text-primary'></span>";

                                            $valorControler = 1;

                                            echo '</span>';

                                        } else {
                                            echo "--:--";
                                        }
                                    }
                                ?>

                            </td>
                            <td>
                                 <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="<?php echo "Esse é o status que o cliente visualiza nesse momento. Quando houver alterações ele será informado.";?>">
                                    <span class="badge badge-<?php echo $cor ?>">
                                        <?php echo $nome_situacao; ?>
                                    </span>
                                </span>
                            </td>
                            <td>
                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo ucwords(strtolower($nome_empresa)); ?>">
                                    <?php
                                        echo strtoupper($fantasia_empresa);
                                    ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    echo date('H\hi - d/m/Y', strtotime($created));
                                ?>
                            </td>
                            <td class="text-right">
                                <?php
                                if (isset($ooops)) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true"
                                          title="Visualizar">
                                            <a href="<?php echo URLADM . 'funcionario-ver-atendimento/ver/' . $id_aten_func . '?pg=' . $this->Dados['pg']; ?>" class="btn btn-outline-primary btn-sm mb-2">
                                                <i class="far fa-eye"></i>
                                            </a>
                                        </span>
                                    <?php
                                }
                                if (($this->Dados['botao']['conclu']) AND ($id_sits_aten_func == 2 OR $id_sits_aten_func == 3)) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Finalizar">
                                        <a href="<?php echo URLADM . 'func-concluir-atendimento/concluir/' . $id_aten_func. '?status='. $id_sits_aten_func .'&pg='.$this->Dados['pg'] . '&aten='.$id_atendimento; ?>" class="btn btn-outline-success btn-sm mb-2" data-confirmFinalizar='Finalizar atendimento'>
                                            <i class="fas fa-clipboard-check"></i>
                                        </a>
                                    </span>
                                <?php
                                }
                                if ( $id_sits_aten_func == 3){
                                ?>
                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Interromper atendimento temporariamente?">
                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id_aten_func . '?status=5&pg='.$this->Dados['pg']; ?>" class="btn btn-outline-warning btn-sm mb-2" data-confirmInterromper='Interromper atendimento temporariamente?'>
                                        <i class="fas fa-hand-paper"></i>
                                    </a>
                                </span>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                            } // Fim do foreach
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


    </div>
    <?php
    //var_dump($this->Dados);
    ?>
    <!-- Container de teste
    <div id="containerTestePhp">


    </div>
    #Ende container de teste-->

</div>


<script type="text/javascript">
    function Parametros(hora_inicio, hora_termino, hora_inicio2, hora_termino2, adms_funcionario_id) {
        document.getElementById('hora_inicio').value = hora_inicio;
        document.getElementById('hora_termino').value = hora_termino;
        document.getElementById('hora_inicio2').value = hora_inicio2;
        document.getElementById('hora_termino2').value = hora_termino2;
        document.getElementById('adms_funcionario_id').value = adms_funcionario_id;
    }
</script>

<!-- Modal -->
<div class="modal fade" id="editarFuncionarioModal" tabindex="-1" role="dialog" aria-labelledby="editandoFuncionario" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editandoFuncionario"><i class="fas fa-eye"></i> Ver Planejamento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="post" action="">
                <div class="modal-body">
                    <fieldset>
                        <legend>Período da manhã:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio">Início</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="hora_inicio" id="hora_inicio" class="form-control" disabled>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino">Término</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino" type="text" id="hora_termino" class="form-control" disabled>
                                    </div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Período da tarde:</legend>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <label for="hora_inicio2">Início</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-start"></i>
                                            </div>
                                        </div>
                                        <input type="text" name="hora_inicio2" id="hora_inicio2" class="form-control" disabled>
                                    </div>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_termino2">Término</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-hourglass-end"></i>
                                            </div>
                                        </div>
                                        <input name="hora_termino2" type="text" id="hora_termino2" class="form-control" disabled>
                                    </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Calculo tempo restante -->
<script src="<?php echo URLADM.'assets/js/temporizador/jquery-1.9.1.min.js'; ?>"></script>
<?php
if (!empty($tempo_restanteUrgente)) {
    $scriptInicio = "<script>";
    $scriptFinal = "</script>";
    // O tempo tem que ser obrigatoriamente em segundos


    $script = $scriptInicio . "var tempoUrgente = '" . $tempo_restanteUrgente . "'; var controlerU = '" . $valorControler . "';" . $scriptFinal;
    echo $script;
    ?>

    <script type="text/javascript">

        //var tempo = new Number();
        //var controler = 0;
        // Tempo em segundos
        //tempo = 7;

        function startCountdownU(){

            // Se o tempo não for zerado
            if(((tempoUrgente - 1) >= 0) && (controlerU == 0)){

                // Pega a parte inteira dos minutos
                var minU = parseInt(tempoUrgente/60);

                // horas, pega a parte inteira dos minutos
                var horU = parseInt(minU/60);

                //atualiza a variável minutos obtendo o tempo restante dos minutos
                minU = minU % 60;


                // Calcula os segundos restantes
                var segU = tempoUrgente%60;

                // Formata o número menor que dez, ex: 08, 07, ...
                if(minU < 10)
                {
                    minU = "0"+minU;
                    minU = minU.substr(0, 2);
                }

                if(segU <=9)
                {
                    segU = "0"+segU;
                }

                if(horU <=9)
                {
                    horU = "0"+horU;
                }

                // Cria a variável para formatar no estilo hora/cronômetro
                horaImprimivelU = horU+':' + minU + ':' + segU;

                //JQuery pra setar o valor
                $("#sessaoUrgente").html(horaImprimivelU);

                // Define que a função será executada novamente em 1000ms = 1 segundo
                setTimeout('startCountdownU()',1000);

                // diminui o tempo
                tempoUrgente--;

            } else {
                controlerU = 1;

                // Pega a parte inteira dos minutos
                var minU = parseInt(tempoUrgente/60);

                // horas, pega a parte inteira dos minutos
                var horU = parseInt(minU/60);

                //atualiza a variável minutos obtendo o tempo excedido dos minutos
                minU = minU % 60;

                // Calcula os segundos excedido
                var segU = tempoUrgente%60;

                // Formata o número menor que dez, ex: 08, 07, ...
                if(minU < 10){
                    minU = "0"+minU;
                    minU = minU.substr(0, 2);
                }
                if(segU <=9){
                    segU = "0"+segU;
                }
                if(horU <=9){
                    horU = "0"+horU;
                }

                // Cria a variável para formatar no estilo hora/cronômetro
                horaImprimivelU = '-' + horU + ':' + minU + ':' + segU;

                //JQuery pra setar o valor
                $('#sessaoUrgente').attr('class', 'text-danger');
                $("#sessaoUrgente").html(horaImprimivelU);

                // Define que a função será executada novamente em 1000ms = 1 segundo
                setTimeout('startCountdownU()',1000);

                // somar o tempo
                tempoUrgente++;
            }

        }

        // Chama a função ao carregar a tela
        startCountdownU();

    </script>

    <?php
}
?>


