<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 05/02/2019
 * Time: 17:40
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados)
//var_dump($this->Dados['listAtendimentosAq']);
if ($this->Dados['listAtendimentosAq']) {
    extract($this->Dados['listAtendimentosAq']);
}


$pg = $this->Dados['pg'];
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Atendimentos Arquivados</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_atendimento']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'gerenciar-atendimento/listar'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-undo-alt"></i> Voltar</a>
                </div>
                <?php
            }
            ?>
        </div>



        <?php
        if (empty($this->Dados['listAtendimentosAq'])) {
            ?>

            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                Nenhum atendimento encontrado!
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
                    <thead class="bg-info text-light my-4">
                    <tr>
                        <th class="d-none d-lg-table-cell">Cod.</th>
                        <th class="">Funcionário</th>
                        <th class="">Tipo</th>
                        <th class="">Situação</th>
                        <th class="">Cliente</th>
                        <th class="d-none d-lg-table-cell">Empresa</th>
                        <th class="">Data/Hora</th>
                        <th class="text-right">Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php

                    foreach ($this->Dados['listAtendimentosAq'] as $atendimento) {
                        extract($atendimento);

                        ?>

                        <tr>
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
                                } else {
                                    echo $funcionario;
                                }
                                ?>
                            </td>
                            <td><?php echo $nome_demanda; ?></td>
                            <td class="text-center">
                                <span class="badge badge-<?php echo $cor; ?>">
                                    <?php echo $nome_situacao; ?>
                                </span>
                            </td>
                            <td><?php echo $cliente; ?></td>
                            <td class="d-none d-sm-table-cell">
                                <span tabindex="0" data-placement="top" data-toggle="tooltip"
                                      title="<?php echo $emp_nome; ?>">
                                    <?php echo $fantasia; ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y H:i', strtotime($created)); ?></td>
                            <td class="text-right">
                                        <span class="d-none d-md-block">
                                            <?php
                                            if ($this->Dados['botao']['vis_atendimento']) { ?>
                                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Visualizar">
                                                    <a href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id . '?pg=' . $this->Dados['pg']; ?>"
                                                        class="btn btn-outline-primary btn-sm my-md-1">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </span>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (($this->Dados['botao']['edit_atendimento']) AND (($nome_situacao != "Cancelado") AND ($id_situacao != 4))) { ?>
                                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar">
                                                    <a href="<?php echo URLADM . 'atendimento-gerente/editar/' . $id . '?pg=' . $this->Dados['pg']; ?>"
                                                       class="btn btn-outline-warning btn-sm my-md-1">
                                                        <i class="far fa-edit"></i>
                                                    </a>
                                                </span>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($this->Dados['botao']['desarqui_atendimento']) { ?>
                                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Desarquivar">
                                                    <a href="<?php echo URLADM . 'atendimento-gerente/desarquivar/' . $id . '?pg=' . $this->Dados['pg']; ?>"
                                                       class="btn btn-outline-dark btn-sm my-md-1"
                                                       data-desarquivar='Tem certeza que deseja desarquivar o atendimento selecionado?'>
                                                        <i class="fas fa-box-open"></i>
                                                    </a>
                                                </span>
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
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php if ($this->Dados['botao']['vis_atendimento']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'atendimento-gerente/ver/' . $id; ?>">Visualizar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'atendimento-gerente/editar/' . $id; ?>">Editar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botao']['desarqui_atendimento']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'atendimento-gerente/desarquivar/' . $id . '?pg=' . $this->Dados['pg']; ?>"
                                               data-desarquivar='Tem certeza que deseja desarquivar o atendimento selecionado?'>Desarquivar</a>
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
        ?>

    </div>
</div>

