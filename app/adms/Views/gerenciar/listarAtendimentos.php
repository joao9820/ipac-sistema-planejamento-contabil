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
//var_dump($this->Dados)
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



        <div class="table-responsive">
            <table class="table table-striped table-hover ">
                <thead class="bg-info text-light my-4">
                <tr>
                    <th class="d-none d-lg-table-cell">Cod.</th>
                    <th class="">Funcionário</th>
                    <th class="">Tipo</th>
                    <th class="">Status</th>
                    <th class="">Cliente</th>
                    <th class="d-none d-lg-table-cell">Empresa</th>
                    <th class="">Data/Solicitação</th>
                    <th class="text-right">Ações</th>
                </tr>
                </thead>

                <tbody>
                <?php

                foreach ($this->Dados['listAtendimentos'] as $atendimento) {
                    extract($atendimento);

                    ?>

                    <tr class="<?php if (($nome_situacao == "Cancelado") OR ($id_situacao == 4)) {echo "text-secondary";} else {echo "text-dark";} ?>">
                        <td class="d-none d-lg-table-cell">
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
                            if (empty($funcionario)) {
                                echo "-";
                            } else { echo $funcionario; }
                            if ($nome_situacao != "Cancelado") {
                                if ($situacao_atendimento == 2) {
                                    echo '<span class="badge badge-warning ml-1">';
                                        echo "Executando";
                                    echo '</span>';
                                } elseif ($situacao_atendimento == 3) {
                                    echo '<span class="badge badge-danger ml-1">';
                                        echo "Pausado";
                                    echo '</span>';
                                } elseif ($situacao_atendimento == 4) {
                                    echo '<span class="badge badge-secondary ml-1">';
                                        echo "Finalizado";
                                    echo '</span>';
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
                        <td><?php echo $cliente; ?></td>
                        <td class="d-none d-sm-table-cell">
                            <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo $emp_nome; ?>">
                                <?php echo $fantasia; ?>
                            </span>
                        </td>
                        <td>
                            <div class="dataAtendimento">
                                <span class="data"><?php echo date('d/m/Y H:i', strtotime($created)); ?></span>
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
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id; ?>">
                                            <i class="far fa-eye"></i> Visualizar
                                        </a>
                                    <?php } ?>
                                    <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                        <a class="dropdown-item" href="<?php echo URLADM . 'atendimento-gerente/editar/'.$id; ?>">
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
