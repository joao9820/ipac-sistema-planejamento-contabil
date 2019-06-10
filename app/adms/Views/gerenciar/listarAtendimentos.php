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

?>
<style>
    .dataAtendimento .legenda {
        font-size: .8em;
    }
    .dataAtendimento .data {
        border: 1px solid rgba(0,0,0,0.125);
        border-radius: 5px;
        padding: 2px 4px;
    }
    .btnOpcoes {
        min-width: 80px;
        margin-right: 4px;
    }
    .bg-progresso {
        background: #edf0f2;
        border: 1px solid rgba(0,0,0,0.125);
    }
    .progress {
        font-size: .7em;
        font-weight: 700;
    }
    .totalAlert {
        color: red !important;
        border-color: red !important;
    }

</style>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto w-100 p-2">
                <h2 class="display-4 titulo offset-2 offset-md-1 ml-0">Atendimentos</h2>
                <div class="d-flex offset-1 offset-md-2">
                    <div class="mr-auto ">
                        <!--
                        <a href="#" class="btn btn-outline-success btn-sm"><i class="far fa-play-circle"></i> Em execução</a>
                        <a href="#" class="btn btn-outline-warning btn-sm"><i class="far fa-pause-circle"></i> Pausado</a>
                        <a href="#" class="btn btn-outline-danger btn-sm"><i class="far fa-clock"></i> Atrasado</a>
                        -->
                    </div>
                    <div class="">
                        <!--
                        <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-circle"></i> Em andamento</a>
                        <a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-check"></i> Concluído</a>
                        <a href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-ban"></i> Cancelado</a>
                        -->
                        <?php if ($this->Dados['botao']['arqui_atendimento']) { ?>
                            <a href="<?php echo URLADM . 'gerenciar-atendimento/arquivado'; ?>" class="btn btn-outline-dark btn-sm"><i class="fas fa-archive"></i> Arquivados</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if (empty($this->Dados['listAtendimentos'])) {
            ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Desculpe, nenhum atendimento registrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
        }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <div class="col-md-12 d-flex justify-content-center justify-content-md-end">
            <form id="FiltroBusca" method="post" action="" class="d-flex flex-column flex-md-row my-4">



                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Caso não escolha uma data inicial será considerado a data atual">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend displayNone">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                        <input name="dataInicial" type="date" class="form-control" id="inlineFormInputGroupUsername2">
                    </div>
                </span>

                <span class="mx-2">até</span>

                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data final">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend displayNone">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                        <input name="dataFinal" type="date" class="form-control" id="inlineFormInputGroupUsername2" required>
                    </div>
                </span>

                <span class="pl-0 pl-md-2">
                    <button class="btn btn-outline-powercar mb-2 mr-2"><i class="fas fa-search"></i></button>
                    <a href="#" class="btn btn-outline-secondary mb-2"><i class="fas fa-eraser"></i></a>
                </span>
            </form>
        </div>

        <?php
        //var_dump($this->Dados['listAtendimentos']);
        ?>

        <div class="table-responsive">
            <table class="table table-hover ">
                <thead class="bg-info text-light my-4">
                <tr>
                    <th class="">Cod.</th>
                    <th class="">Planejamento</th>
                    <th><span class='luzAlert' tabindex='0' data-placement='right' data-toggle='tooltip' title='Total de atividades definidas para um ou mais funcionários'>Qtd/Atividades</span></th>
                    <th>Progresso</th>
                    <th class="">Demanda</th>
                    <th class="">
                        <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Descrição do atendimento.'>Descrição</span>
                    </th>
                    <th class="">Atendimento</th>
                    <th class="">Empresa Cliente</th>
                    <th class="">Data da Solicitação</th>
                    <th class="text-right">Ações</th>
                </tr>
                </thead>

                <tbody>
                <?php

                foreach ($this->Dados['listAtendimentos'] as $atendimento) {
                    extract($atendimento);

                    ?>

                    <tr class="">
                        <?php
                        if(($nome_situacao == "Concluído") AND ($id_situacao == 3)){
                            echo '<td class="">';
                            echo '<i class="fas fa-lightbulb text-light faIpac"></i>';
                            if ($id < 10){
                                echo "000".$id;
                            } elseif ($id < 100){
                                echo "00".$id;
                            } elseif ($id < 100){
                                echo "0".$id;
                            } else {
                                echo $id;
                            }
                        } else {
                            ?>
                        <td class=" <?php if (($data_fatal_atividade < date('Y-m-d'))and (!empty($data_fatal_atividade))) {
                                    echo "text-danger";
                                } else {
                                    echo "text-dark";
                                } ?>">
                                <?php
                                    if (($data_fatal_atividade < date('Y-m-d'))and (!empty($data_fatal_atividade))){
                                        echo "<span class='luzAlert' tabindex='0' data-placement='right' data-toggle='tooltip' title='Este atendimento está com uma (ou mais) atividade(s) com entrega atrasada(s).'>";
                                        echo '<a href="' . URLADM . 'atendimento-funcionarios/listar/' . $adms_demanda_id .'?aten='.$id.'" class="text-danger" >';
                                            echo '<i class="fas fa-lightbulb faIpac"></i>';
                                        echo '</a>';
                                        echo "</span>";
                                    } else {
                                        echo '<i class="fas fa-lightbulb text-light faIpac"></i>';
                                    }
                                ?>
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
                            } // fim do if para exibir luz ou não
                            ?>
                        </td>
                        <td>
                            <?php
                            if(($nome_situacao == "Cancelado") AND ($id_situacao == 4)) {
                                echo "";
                            } else {
                                ?>
                                <span class="d-flex justify-content-start">
                                    <a href="<?php echo URLADM . 'atendimento-funcionarios/listar/' . $adms_demanda_id .'?aten='.$id.'&pg='.$this->Dados['pg']; ?>" class="btn btn-outline-secondary border-0 btn-sm mb-2 btnOpcoes"  >
                                        <i class="fas fa-pen-square"></i> Planejamento
                                    </a>
                                </span>
                                <?php
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if(($nome_situacao == "Cancelado") AND ($id_situacao == 4)) {
                                echo "";
                            } else {
                                ?>
                                <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="Concluídas | Total atividades definidas">

                                <?php
                                if ($total_atividade != null) {
                                    if ($total_atividade_concluida == null) {
                                        $total_atividade_concluida = 0;
                                    }
                                    echo '<span class="badge badge-secondary">';
                                    echo $total_atividade_concluida;
                                    echo '</span> | ';
                                    echo '<span class="badge badge-secondary">';
                                    echo $total_atividade;
                                    echo '</span>';
                                } else {
                                    echo "--";
                                }
                                ?>
                                </span>
                                <?php
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <?php
                            if(($nome_situacao == "Cancelado") AND ($id_situacao == 4)) {
                                echo "";
                            } else {
                                ?>
                                <?php
                                if ($total_atividade != null){
                                    ?>
                                    <div class="progress bg-progresso">
                                        <?php
                                        $total = (int)$total_atividade;
                                        $concluido = (int)$total_atividade_concluida;
                                        $porcentagem = ($concluido * 100) / $total;
                                        $porcentagem = number_format($porcentagem, 0, '.', '');
                                        //echo number_format($porcentagem, 2, '.', '') . "%";
                                        if ($porcentagem < 10){
                                            $corPorcent = "danger text-secondary";
                                        } elseif ($porcentagem < 50){
                                            $corPorcent = "warning";
                                        } elseif ($porcentagem < 100 ){
                                            $corPorcent = "primary";
                                        } elseif ($porcentagem == 100) {
                                            $corPorcent = "success";
                                        }
                                        ?>

                                        <div class="progress-bar bg-<?php echo $corPorcent; ?>" role="progressbar" style="width: <?php echo $porcentagem; ?>%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                            <?php
                                            echo $porcentagem . "%";
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    echo "--";
                                }
                            }
                            ?>
                        </td>
                        <td><?php echo $nome_demanda; ?></td>
                        <td class="text-center">
                            <?php
                                if (!empty($descricao_atendimento)){
                            ?>
                                <span tabindex="0" data-placement="right" data-toggle="tooltip" title="<?php echo $descricao_atendimento; ?>">
                                    <i class="far fa-file-alt fa-2x text-secondary"></i>
                                </span>
                            <?php
                            }
                            ?>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-<?php echo $cor; ?>">
                                <?php echo $nome_situacao; ?>
                            </span>
                        </td>
                        <td class="">
                            <span tabindex="0" data-placement="right" data-toggle="tooltip" title="<?php echo $emp_nome; ?>">
                                <?php echo $fantasia; ?>
                            </span>
                        </td>
                        <td>
                            <div class="dataAtendimento d-flex flex-row">
                                <span class="data bg-light text-secondary shadow"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y \a\s H\hi', strtotime($created)); ?></span>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="d-none d-md-block">
                                <?php
                                if ($this->Dados['botao']['vis_atendimento']) { ?>
                                     <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Visualizar">
                                        <a href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id. '?pg='.$this->Dados['pg'].'&demanda='.$adms_demanda_id; ?>" class="btn btn-outline-primary btn-sm my-md-1">
                                            <i class="far fa-eye"></i>
                                        </a>
                                     </span>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($this->Dados['botao']['edit_atendimento']) AND (($nome_situacao != "Cancelado") AND ($id_situacao != 4))) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar">
                                        <a href="<?php echo URLADM . 'atendimento-gerente/editar/'.$id. '?pg='.$this->Dados['pg'].'&demanda='.$adms_demanda_id; ?>" class="btn btn-outline-warning btn-sm my-md-1">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>

                                <?php
                                if (($this->Dados['botao']['arquivar_atendimento']) AND (($nome_situacao == "Concluído")  AND ($id_situacao == 3))) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Arquivar">
                                        <a href="<?php echo URLADM . 'atendimento-gerente/arquivar/'.$id . '?pg='.$this->Dados['pg']; ?>" class="btn btn-outline-secondary btn-sm my-md-1"
                                        data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'>
                                            <i class="fas fa-folder-open"></i>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>

                            </span>
                            <div class="dropdown d-block d-md-none">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                    <?php if ($this->Dados['botao']['vis_atendimento']) { ?>
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id. '?pg='.$this->Dados['pg'].'&demanda='.$adms_demanda_id; ?>">
                                            <i class="far fa-eye"></i> Visualizar
                                        </a>
                                    <?php } ?>
                                    <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/editar/'.$id. '?pg='.$this->Dados['pg'].'&demanda='.$adms_demanda_id; ?>">
                                            <i class="far fa-edit"></i> Editar
                                        </a>
                                    <?php } ?>
                                    <!--
                                    <?php if ($this->Dados['botao']['arquivar_atendimento']) { ?>
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/arquivar/'.$id . '?pg='.$this->Dados['pg']; ?>"
                                           data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'>
                                            <i class="fas fa-folder-open"></i> Arquivar
                                        </a>
                                    <?php } ?>
                                    -->
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
            echo $this->Dados['paginacao'];
        ?>
    </div>
</div>
