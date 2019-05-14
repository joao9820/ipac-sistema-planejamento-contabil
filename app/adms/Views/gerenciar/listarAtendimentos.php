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
        font-weight: 800;
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
                <h2 class="display-4 titulo">Atendimentos</h2>
                <div class="d-flex">
                <div class="mr-auto ">
                    <a href="#" class="btn btn-outline-success btn-sm"><i class="far fa-play-circle"></i> Em execução</a>
                    <a href="#" class="btn btn-outline-warning btn-sm"><i class="far fa-pause-circle"></i> Pausado</a>
                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="far fa-clock"></i> Atrasado</a>
                </div>
                <div class="">
                    <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-circle"></i> Em andamento</a>
                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="fas fa-check"></i> Concluído</a>
                    <a href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-ban"></i> Cancelado</a>
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


        <form method="post" action="" class="form-inline my-4">



            <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Caso não escolha uma data inicial será considerado a data atual">
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                    <input name="dataInicial" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2">
                </div>
            </span>


            <span class="mr-2">até</span>

            <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data final">
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                    <input name="dataFinal" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2" required>
                </div>
            </span>

            <button class="btn btn-outline-warning mb-2 mr-2"><i class="fas fa-search"></i></button>
            <a href="#" class="btn btn-outline-secondary mb-2"><i class="fas fa-eraser"></i></a>
        </form>

        <?php
        //var_dump($this->Dados['listAtendimentos']);
        ?>

        <div class="table-responsive">
            <table class="table table-striped table-hover ">
                <thead class="bg-info text-light my-4">
                <tr>
                    <th class="d-none d-lg-table-cell">Cod.</th>
                    <th class="">Planejamento</th>
                    <th><span class='luzAlert' tabindex='0' data-placement='right' data-toggle='tooltip' title='Total de atividades definidas para um ou mais funcionários'>Qtd/Atividades</span></th>
                    <th>Progresso</th>
                    <th class="">Demanda</th>
                    <th class="">Status do Atendimento</th>
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
                        <td class="d-none d-lg-table-cell <?php if (($data_fatal_atividade < date('Y-m-d'))and (!empty($data_fatal_atividade))) {
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
                            ?>
                        </td>
                        <td>
                            <?php
                            if(($nome_situacao == "Cancelado") AND ($id_situacao == 4)) {
                                echo "";
                            } else {
                                ?>
                                <span class="d-flex justify-content-start">
                                <span tabindex='0' data-placement='right' data-toggle='tooltip' title='Clique para acessar a página de visualização dos funfionários responsável por este atendimento'>
                                    <a href="<?php echo URLADM . 'atendimento-funcionarios/listar/' . $adms_demanda_id .'?aten='.$id.'&pg='.$this->Dados['pg']; ?>" class="btn btn-outline-secondary border-0 btn-sm mb-2 btnOpcoes"  >
                                        <i class="fas fa-pen-square"></i> Planejamento
                                    </a>
                                </span>
                            </span>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if(($nome_situacao == "Cancelado") AND ($id_situacao == 4)) {
                                echo "";
                            } else {
                                ?>
                                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Concluídas/Total atividades definidas">
                                <span class="badge badge-secondary">
                                <?php
                                if ($total_atividade != null) {
                                    if ($total_atividade_concluida == null) {
                                        $total_atividade_concluida = 0;
                                    }
                                    echo $total_atividade_concluida . "/" . $total_atividade;
                                } else {
                                    echo "--";
                                }
                                ?>
                                </span>
                            </span>
                                <?php
                            }
                            ?>
                        </td>
                        <td>
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
                        <td class="">
                            <span class="badge badge-<?php echo $cor; ?>">
                                <?php echo $nome_situacao; ?>
                            </span>
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo $emp_nome; ?>">
                                <?php echo $fantasia; ?>
                            </span>
                        </td>
                        <td>
                            <div class="dataAtendimento">
                                <span class="data bg-light shadow"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y \a\s H\hi', strtotime($created)); ?></span>
                            </div>
                        </td>
                        <td class="text-right">
                            <span class="d-none d-md-block">
                                <?php
                                if ($this->Dados['botao']['vis_atendimento']) { ?>
                                     <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Visualizar">
                                        <a href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id. '?pg='.$this->Dados['pg']; ?>" class="btn btn-outline-primary btn-sm my-md-1">
                                            <i class="far fa-eye"></i>
                                        </a>
                                     </span>
                                    <?php
                                }
                                ?>
                                <?php
                                if (($this->Dados['botao']['edit_atendimento']) AND (($nome_situacao != "Cancelado") AND ($id_situacao != 4))) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar">
                                        <a href="<?php echo URLADM . 'atendimento-gerente/editar/'.$id. '?pg='.$this->Dados['pg']; ?>" class="btn btn-outline-warning btn-sm my-md-1">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </span>
                                    <?php
                                }
                                ?>
                                <?php
                                if ($this->Dados['botao']['arquivar_atendimento']) { ?>
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
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id. '?pg='.$this->Dados['pg']; ?>">
                                            <i class="far fa-eye"></i> Visualizar
                                        </a>
                                    <?php } ?>
                                    <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/editar/'.$id. '?pg='.$this->Dados['pg']; ?>">
                                            <i class="far fa-edit"></i> Editar
                                        </a>
                                    <?php } ?>
                                    <?php if ($this->Dados['botao']['arquivar_atendimento']) { ?>
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/arquivar/'.$id . '?pg='.$this->Dados['pg']; ?>"
                                           data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'>
                                            <i class="fas fa-folder-open"></i> Arquivar
                                        </a>
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

    </div>
</div>
