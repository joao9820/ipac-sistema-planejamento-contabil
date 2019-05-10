<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//echo $_SESSION['adms_empresa_id'];
//var_dump($this->Dados['jornadaDeTrabalho']);
extract($this->Dados['jornadaDeTrabalho']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Atendimentos Pendente</h2>
            </div>

            <div class="d-flex flex-column" data-placement="top" data-toggle="tooltip" title="Hora extra pra hoje">
                <span>Hora extra</span>
                <span class="btn btn-secondary shadow">02:00</span>
            </div>
            <span tabindex="0" >
                            <i class="fas fa-question-circle text-secondary"></i>
                        </span>
        </div>



        <?php

        if (empty($this->Dados['listAtendimentoPendente']) AND empty($this->Dados['listAtendimentoPendenteUrgente']) AND empty($this->Dados['listAtendimentoFinalizado'])) {
            ?>

            <div class="alert alert-info alert-dismissible fade show" role="alert">
                No momento não existe nenhum atendimento pendente!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
        } else {
            ?>

            <?php
                if (isset($this->Dados['listAtendimentoPendenteUrgente']) AND !empty($this->Dados['listAtendimentoPendenteUrgente'])) {

                ?>
                    <div class="d-flex flex-row align-items-center">
                        <h4 class="text-dark mr-2">
                            Imediato
                        </h4>
                        <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Atenção, esse atendimento tem prioridade sobre os atendimentos normais. Deve ser realizado imediatamente">
                            <i class="fas fa-question-circle text-secondary"></i>
                        </span>
                    </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr class="bg-danger text-light">
                            <th>Codº</th>
                            <th>Status</th>
                            <th>Tipo</th>
                            <th class="d-none d-lg-table-cell">Situação</th>
                            <th class="">Empresa</th>
                            <th class="d-none d-lg-table-cell">Descrição</th>
                            <th class="d-none d-lg-table-cell">Data solititação</th>
                            <th class="">Hora de início</th>
                            <th class=""><span tabindex="0" data-placement="left" data-toggle="tooltip"
                                               title="Caso a hora atual menos a hora de inicio seja maior que o tempo de execução da atividade, o contador ficará vermelhor e negativo.">Tempo Restante</span>
                            </th>
                            <th class="text-center">Ações</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php

                        foreach ($this->Dados['listAtendimentoPendenteUrgente'] as $atendimento) {
                            extract($atendimento);

                            ?>

                            <tr>
                                <td class="text-center">
                                    <?php
                                    if ($id < 10){
                                        echo "000".$id;
                                    } elseif ($id < 100){
                                        echo "00".$id;
                                    } elseif ($id < 100){
                                        echo "0".$id;
                                    } else {
                                        echo $id;
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($sits_aten_func_id == 1) {
                                        // Não iniciado
                                        ?>
                                        <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
                                            <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$sits_aten_func_id.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                               data-sitAtenIniciar='Tem certeza que deseja iniciar o atendimento?'>
                                                <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                    <?php echo $nome_sits_aten_func; ?>
                                                </span>
                                            </a>
                                        </span>
                                        <?php
                                    } elseif ($sits_aten_func_id == 2){
                                        // Iniciado
                                        ?>
                                        <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para pausar o atendimento.'>
                                            <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$sits_aten_func_id.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                               data-sitAtenPausar='Tem certeza que deseja pausar o atendimento?'>

                                                <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                    <?php echo $nome_sits_aten_func; ?>
                                                </span>
                                            </a>
                                        </span>
                                        <?php
                                    } elseif ($sits_aten_func_id == 3) {
                                        // Pausado
                                        ?>
                                        <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para continuar o atendimento.'>
                                            <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$sits_aten_func_id.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                               data-sitAtenContinuar='Tem certeza que deseja da continuidade ao atendimento agora?'>
                                                <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                    <?php echo $nome_sits_aten_func; ?>
                                                </span>
                                            </a>
                                        </span>
                                        <?php
                                    } else {
                                        // Finalizado
                                        ?>
                                        <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Atendimento finalizado.'>
                                            <a href="#" class="btn btn-secondary btn-sm my-md-1">
                                                <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                    <?php echo $nome_sits_aten_func; ?>
                                                </span>
                                            </a>
                                        </span>
                                        <?php
                                    }
                                    ?>

                                </td>
                                <td><?php echo $demanda; ?></td>
                                <td>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true"
                                          title="<?php
                                          //if ($id_situacao == 1) {
                                          echo "Esse é o status que o cliente visualiza nesse momento. Quando houver alterações ele será informado.";
                                          //} elseif ($id_situacao == 2) {
                                          //echo "Seu atendimento está agora em andamento assim que for finalizado você será informado.";
                                          //}
                                          ?>">
                                        <span class="badge badge-<?php echo $cor ?>">
                                            <?php echo $nome_situacao; ?>
                                        </span>
                                    </span>

                                </td>
                                <td class="d-none d-sm-table-cell">
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip"
                                          title="<?php echo ucwords(strtolower($nome_empresa)); ?>">
                                        <?php echo ucwords(strtolower($fantasia_empresa)); ?>
                                    </span>
                                </td>
                                <td class="d-none d-sm-table-cell"><?php echo $descricao; ?></td>
                                <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y H:i', strtotime($created)); ?></td>
                                <td class="text-center">
                                    <?php
                                    if (!empty($inicio_atendimento)) {
                                        ?>
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip"
                                              title="Dia <?php echo date('d/m/Y', strtotime($inicio_atendimento)); ?>">
                                                    <?php echo date('H:i', strtotime($inicio_atendimento)); ?>
                                                </span>
                                        <?php
                                    } else {
                                        echo "--:--";
                                    }
                                    ?>
                                </td>
                                <td class="text-center">

                                    <?php
                                    if ($sits_aten_func_id == 1) {
                                        echo "--:--";
                                    } elseif ($sits_aten_func_id== 3){

                                        echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos/segundos">';

                                        if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {
                                            echo date('H:i:s', strtotime($at_tempo_restante));
                                        }
                                        elseif (!empty($at_tempo_excedido)) {

                                            echo "<span id='sessao' class='text-danger'>";
                                            echo "-".date('H:i:s', strtotime($at_tempo_excedido));
                                            echo "</span>";

                                        }
                                        else {
                                            echo "--:--";
                                        }

                                        echo '</span>';

                                    }
                                    elseif ($sits_aten_func_id == 2) {

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

                                        }
                                        elseif (!empty($at_tempo_excedido)){

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

                                        }
                                        else {
                                            echo "--:--";
                                        }
                                    }

                                    ?>

                                </td>
                                <td class="text-center">
                                    <span class="d-none d-md-block">
                                        <?php
                                        if ($this->Dados['botao']['vis']) { ?>
                                            <a href="<?php echo URLADM . 'funcionario-ver-atendimento/ver/' . $id. '?pg='.$this->Dados['pg']; ?>"
                                               class="btn btn-info btn-sm my-md-1">Visualizar</a>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if ($this->Dados['botao']['edit']) { ?>
                                            <a href="<?php echo URLADM . 'funcionario-editar-atendimento/edit/' . $id. '?pg='.$this->Dados['pg']; ?>"
                                               class="btn btn-warning btn-sm my-md-1">Editar</a>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (($this->Dados['botao']['conclu']) AND ($sits_aten_func_id == 2 OR $sits_aten_func_id == 3)) { ?>
                                            <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status=4&pg='.$this->Dados['pg']; ?>"
                                               class="btn btn-success btn-sm my-md-1" data-confirmFinalizar='Para finalizar o atendimento selecionado clique em finalizar. Atenção, uma vez finalizado o atendimento não pode ser retomado.'
                                            >Finalizar</a>
                                            <?php
                                        }
                                        ?>
                                    </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                                id="acoesListar" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="acoesListar">
                                            <?php if ($this->Dados['botao']['vis']) { ?>
                                                <a class="dropdown-item"
                                                   href="<?php echo URLADM . 'funcionario-ver-atendimento/ver/' . $id. '?pg='.$this->Dados['pg']; ?>">Visualizar</a>
                                            <?php } ?>
                                            <?php if ($this->Dados['botao']['edit']) { ?>
                                                <a class="dropdown-item"
                                                   href="<?php echo URLADM . 'funcionario-editar-atendimento/edit/' . $id. '?pg='.$this->Dados['pg']; ?>">Editar</a>
                                            <?php } ?>
                                            <?php if (($this->Dados['botao']['conclu']) AND ($id_sits_aten_func == 2 OR $sits_aten_func_id == 3)) { ?>
                                                <a class="dropdown-item"
                                                   href="<?php echo URLADM . 'func-concluir-atendimento/concluir/' . $id. '?status=4&pg='.$this->Dados['pg']; ?>" data-confirmFinalizar='Para finalizar o atendimento selecionado clique em finalizar. Atenção, uma vez finalizado o atendimento não pode ser retomado.'
                                                >Finalizar</a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <?php
                        }
                        ?>


                        </tbody>

                    </table>

                </div>

                <?php
            }
            ?>

            <?php
                if (isset($this->Dados['listAtendimentoPendente']) AND !empty($this->Dados['listAtendimentoPendente'])) {
                    ?>
                    <h4 class="text-dark mt-5">Normal</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                            <tr class="">
                                <th>Codº</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th class="d-none d-lg-table-cell">Situação</th>
                                <th class="">Empresa</th>
                                <th class="d-none d-lg-table-cell">Descrição</th>
                                <th class="d-none d-lg-table-cell">Data solititação</th>
                                <th class="">Hora de início</th>
                                <th class="">Duração atividade</th>
                                <th class="">Horá disponível / hoje</th>
                                <th class="">
                                    <span tabindex="0" data-placement="left" data-toggle="tooltip" title="Caso a hora atual menos a hora de inicio seja maior que o tempo de execução da atividade, o contador ficará vermelhor e negativo.">Tempo Restante</span>
                                </th>
                                <th class="text-center">Ações</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php
                            $partesJ = explode(':', $jornada_de_trabalho);
                            $cargaHoraria = $partesJ[0] * 3600 + $partesJ[1] * 60 + $partesJ[2];
                            echo $cargaHoraria;
                            $contador = 0;

                            $outro_dia = 0;
                            $contData = 0;

                            $controle = 0;

                            foreach ($this->Dados['listAtendimentoPendente'] as $atendimento) {
                                extract($atendimento);
                                $contador++;
                                ?>

                                <tr>
                                    <td class="text-center">
                                        <?php
                                            if ($id < 10){
                                                echo "000".$id;
                                            } elseif ($id < 100){
                                                echo "00".$id;
                                            } elseif ($id < 100){
                                                echo "0".$id;
                                            } else {
                                                echo $id;
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ($id_sits_aten_func == 1) {
                                                // Não iniciado
                                                ?>
                                                <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
                                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                                   data-sitAtenIniciar='Tem certeza que deseja iniciar o atendimento?'>
                                                        <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                            <?php echo $nome_sits_aten_func; ?>
                                                        </span>
                                                    </a>
                                                </span>
                                                <?php
                                            } elseif ($id_sits_aten_func == 2){
                                                // Iniciado
                                                ?>
                                                <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para pausar o atendimento.'>
                                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                                       data-sitAtenPausar='Tem certeza que deseja pausar o atendimento?'>
                                                        <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                            <?php echo $nome_sits_aten_func; ?>
                                                        </span>
                                                    </a>
                                                </span>
                                                <?php
                                            } elseif ($id_sits_aten_func == 3) {
                                                // Pausado
                                                ?>
                                                <span tabindex='0' data-placement='top' data-toggle='tooltip' title='Clique para continuar o atendimento.'>
                                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                                       data-sitAtenContinuar='Tem certeza que deseja da continuidade ao atendimento agora?'>
                                                        <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                            <?php echo $nome_sits_aten_func; ?>
                                                        </span>
                                                    </a>
                                                </span>
                                                <?php
                                            } else {
                                                // Finalizado
                                                ?>
                                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Atendimento finalizado.'>
                                                    <a href="#" class="btn btn-secondary btn-sm my-md-1">
                                                        <span class='badge badge-pill badge-<?php echo $cor_sit_aten_func; ?>'>
                                                            <?php echo $nome_sits_aten_func; ?>
                                                        </span>
                                                    </a>
                                                </span>
                                                <?php
                                            }
                                        ?>

                                    </td>
                                    <td><?php echo $demanda; ?></td>
                                    <td>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true"
                                              title="<?php
                                              //if ($id_situacao == 1) {
                                              echo "Esse é o status que o cliente visualiza nesse momento. Quando houver alterações ele será informado.";
                                              //} elseif ($id_situacao == 2) {
                                              //echo "Seu atendimento está agora em andamento assim que for finalizado você será informado.";
                                              //}
                                              ?>">
                                            <span class="badge badge-<?php echo $cor ?>">
                                                <?php echo $nome_situacao; ?>
                                            </span>
                                        </span>

                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span tabindex="0" data-placement="top" data-toggle="tooltip"
                                              title="<?php echo ucwords(strtolower($nome_empresa)); ?>">
                                            <?php echo ucwords(strtolower($fantasia_empresa)); ?>
                                        </span>
                                    </td>
                                    <td class="d-none d-sm-table-cell"><?php echo $descricao; ?></td>
                                    <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y H:i', strtotime($created)); ?></td>
                                    <td class="text-center">
                                        <?php
                                            if ($outro_dia == 0){

                                                if (!empty($inicio_atendimento)) {

                                                    ?>
                                                    <span tabindex="0" data-placement="top" data-toggle="tooltip"
                                                          title="Dia <?php echo date('d/m/Y', strtotime($inicio_atendimento)); ?>">
                                                    <?php echo date('H:i', strtotime($inicio_atendimento)); ?>
                                                </span>
                                                    <?php
                                                } else {

                                                    if($controle == 0) {
                                                        //echo "Aaa";
                                                        //echo date('H:i', strtotime('+1 hours'));

                                                        $controle = 1;
                                                    } else {
                                                        //echo "bbb";
                                                    }


                                                    echo "--:--";

                                                }
                                            } else {

                                                if ($contData != 1) {
                                                    $contData = 1;
                                                    echo date('d/m/Y', strtotime('+1 days')) . " 08:00";
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        echo date('H:i', strtotime($duracao_atendimento));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        // hora disponivel calcular a jornada de trabalho menos a duracao da atividade
                                        if (!empty($at_tempo_restante)) {
                                            if ($contador == 1) {
                                                $tempo = gmdate('H:i', strtotime($jornada_de_trabalho) - strtotime($at_tempo_restante) );

                                                echo $tempo;
                                            } else {

                                                $tempo = gmdate('H:i', strtotime($tempo) - strtotime($at_tempo_restante) );

                                                echo $tempo;
                                            }

                                        } else {
                                            if ($contador == 1) {
                                                $tempo = gmdate('H:i', strtotime($jornada_de_trabalho) - strtotime($duracao_atendimento) );

                                                echo $tempo;
                                            } else {


                                                $horaA = strtotime($tempo);
                                                $horaB = strtotime($duracao_atendimento);

                                                if($tempo > $duracao_atendimento){
                                                    $tempo = gmdate('H:i', strtotime($tempo) - strtotime($duracao_atendimento) );

                                                    if ($tempo >= $duracao_atendimento) {
                                                        echo $tempo;
                                                    }
                                                    if ($tempo < $duracao_atendimento){
                                                        $outro_dia = 1;
                                                    }
                                                } else {
                                                    //$tempo = gmdate('H:i', strtotime($jornada_de_trabalho) - strtotime($duracao_atendimento) );
                                                    echo $tempo;
                                                    //echo "</br>Insuficiente para realizar o atendimento hoje.";
                                                    $outro_dia = 1;

                                                }


                                                //$tempo = gmdate('H:i', strtotime($tempo) - strtotime($duracao_atendimento) );
                                            }
                                        }


                                        ?>
                                    </td>

                                    <td class="text-center">


                                        <?php
                                        if ($id_sits_aten_func == 1) {
                                            echo "--:--";
                                        } elseif ($id_sits_aten_func == 3){

                                            echo '<span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos/segundos">';

                                            if (!empty($at_tempo_restante) AND empty($at_tempo_excedido)) {
                                                echo date('H:i:s', strtotime($at_tempo_restante));
                                            }
                                            elseif (!empty($at_tempo_excedido)) {

                                                echo "<span id='sessao' class='text-danger'>";
                                                echo "-".date('H:i:s', strtotime($at_tempo_excedido));
                                                echo "</span>";

                                            }
                                            else {
                                                echo "--:--";
                                            }

                                            echo '</span>';


                                        }
                                        elseif ($id_sits_aten_func == 2) {

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

                                            }
                                            elseif (!empty($at_tempo_excedido)){

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

                                            }
                                            else {
                                                echo "--:--";
                                            }
                                        }
                                        ?>

                                    </td>

                                    <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <?php
                                            if ($this->Dados['botao']['vis']) { ?>
                                                <a href="<?php echo URLADM . 'funcionario-ver-atendimento/ver/' . $id. '?pg='.$this->Dados['pg']; ?>"
                                                   class="btn btn-info btn-sm my-md-1">Visualizar</a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($this->Dados['botao']['edit']) { ?>
                                                <a href="<?php echo URLADM . 'funcionario-editar-atendimento/edit/' . $id. '?pg='.$this->Dados['pg']; ?>"
                                                   class="btn btn-warning btn-sm my-md-1">Editar</a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (($this->Dados['botao']['conclu']) AND ($id_sits_aten_func == 2 OR $id_sits_aten_func == 3)) { ?>
                                                <a href="<?php echo URLADM . 'func-concluir-atendimento/concluir/' . $id. '?status=4&pg='.$this->Dados['pg']; ?>"
                                                   class="btn btn-success btn-sm my-md-1" data-confirmFinalizar='Para finalizar o atendimento selecionado clique em finalizar. Atenção, uma vez finalizado o atendimento não pode ser retomado.'
                                                >Finalizar</a>
                                                <?php
                                            }
                                            ?>
                                        </span>
                                        <div class="dropdown d-block d-md-none">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                                    id="acoesListar" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="acoesListar">
                                                <?php if ($this->Dados['botao']['vis']) { ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo URLADM . 'funcionario-ver-atendimento/ver/' . $id. '?pg='.$this->Dados['pg']; ?>">Visualizar</a>
                                                <?php } ?>
                                                <?php if ($this->Dados['botao']['edit']) { ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo URLADM . 'funcionario-editar-atendimento/edit/' . $id. '?pg='.$this->Dados['pg']; ?>">Editar</a>
                                                <?php } ?>
                                                <?php if (($this->Dados['botao']['conclu']) AND ($id_sits_aten_func == 2 OR $id_sits_aten_func == 3)) { ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo URLADM . 'func-concluir-atendimento/concluir/' . $id. '?status=4&pg='.$this->Dados['pg']; ?>" data-confirmFinalizar='Para finalizar o atendimento selecionado clique em finalizar. Atenção, uma vez finalizado o atendimento não pode ser retomado.'
                                                    >Finalizar</a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <?php
                            }
                            ?>


                            </tbody>

                        </table>

                        <?php

                        echo $this->Dados['paginacao'];

                        ?>

                    </div>

                    <?php
                }
        }
        echo $jornada_de_trabalho;
        echo $hora_extra;
        var_dump($this->Dados['jornadaDeTrabalho']);

        var_dump($this->Dados['listAtendimentoPendente']);
        ?>


    </div>

</div>
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


