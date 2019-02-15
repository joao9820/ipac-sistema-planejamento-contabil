<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//echo $_SESSION['adms_empresa_id'];
//var_dump($this->Dados);

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Atendimentos Pendente</h2>
            </div>
        </div>



        <?php


        if (isset($_SESSION['msg']))
        {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        if (empty($this->Dados['listAtendimentoPendente'])) {
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
                <h4 class="text-dark mt-5 mb-3">
                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Atenção, esse atendimento tem prioridade sobre os atendimentos normais. Deve ser realizado imediatamente">
                        <i class="fas fa-question-circle"></i>
                    </span>
                    Imediato
                </h4>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead>
                        <tr class="bg-warning">
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
                                <td>
                                    <?php
                                    if ($id_sits_aten_func == 1) {
                                        // Não iniciado
                                        ?>
                                        <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
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
                                        <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para pausar o atendimento.'>
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
                                        <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
                                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                                       data-sitAtenIniciar='Tem certeza que deseja da continuidade ao atendimento agora?'>
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
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Dia 00/00/0000">
                                        00:00
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos">
                                        00:00
                                    </span>
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

                                            </span>
                                    <div class="dropdown d-block d-md-none">
                                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                                id="acoesListar" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            Ações
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right"
                                             aria-labelledby="acoesListar">
                                            <?php if ($this->Dados['botao']['vis_atendimento']) { ?>
                                                <a class="dropdown-item"
                                                   href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id. '?pg='.$this->Dados['pg']; ?>">Visualizar</a>
                                            <?php } ?>
                                            <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                                <a class="dropdown-item"
                                                   href="<?php echo URLADM . 'editar-demanda/edit-demanda/' . $id. '?pg='.$this->Dados['pg']; ?>">Editar</a>
                                            <?php } ?>
                                            <?php if (($this->Dados['botao']['can_atendimento']) AND ($id_situacao == 1)) { ?>
                                                <a class="dropdown-item"
                                                   href="<?php echo URLADM . 'cancelar-atendimento/cancelar/' . $id . '?pg=' . $this->Dados['pg']; ?>"
                                                   data-cancelar='Tem certeza que deseja excluir o atendimento selecionado?'>Cancelar</a>
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
                            <tr class="bg-secondary text-light">
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

                            foreach ($this->Dados['listAtendimentoPendente'] as $atendimento) {
                                extract($atendimento);

                                ?>

                                <tr>
                                    <td>
                                        <?php
                                            if ($id_sits_aten_func == 1) {
                                                // Não iniciado
                                                ?>
                                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
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
                                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para pausar o atendimento.'>
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
                                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para iniciar atendimento.'>
                                                    <a href="<?php echo URLADM . 'atendimento-status/alterar/'.$id . '?status='.$id_sits_aten_func.'&pg='.$this->Dados['pg']; ?>" class="btn btn-<?php echo $cor_sit_aten_func; ?> btn-sm my-md-1"
                                                       data-sitAtenIniciar='Tem certeza que deseja da continuidade ao atendimento agora?'>
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
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Dia 00/00/0000">
                                        00:00
                                    </span>
                                    </td>
                                    <td class="text-center">
                                    <span tabindex="0" data-placement="top" data-toggle="tooltip" title="Hora/minutos">
                                        00:00
                                    </span>
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

                                        </span>
                                        <div class="dropdown d-block d-md-none">
                                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                                    id="acoesListar" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                Ações
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right"
                                                 aria-labelledby="acoesListar">
                                                <?php if ($this->Dados['botao']['vis_atendimento']) { ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id. '?pg='.$this->Dados['pg']; ?>">Visualizar</a>
                                                <?php } ?>
                                                <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo URLADM . 'editar-demanda/edit-demanda/' . $id. '?pg='.$this->Dados['pg']; ?>">Editar</a>
                                                <?php } ?>
                                                <?php if (($this->Dados['botao']['can_atendimento']) AND ($id_situacao == 1)) { ?>
                                                    <a class="dropdown-item"
                                                       href="<?php echo URLADM . 'cancelar-atendimento/cancelar/' . $id . '?pg=' . $this->Dados['pg']; ?>"
                                                       data-cancelar='Tem certeza que deseja excluir o atendimento selecionado?'>Cancelar</a>
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
        ?>


    </div>

</div>
