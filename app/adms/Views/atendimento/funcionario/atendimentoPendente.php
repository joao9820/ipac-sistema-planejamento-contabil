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

        <div class="d-flex">
            <?php
            if ($this->Dados['botao']['abrir']) {
                ?>
                <a href="<?php echo URLADM . 'novo-atendimento/novo'; ?>">
                    <div class="p-2 mr-auto">
                        <button class="btn btn-success btn-sm">
                            Novo
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
            <div class="ml-auto">
                <?php
                if ($this->Dados['botao']['vis']) {
                    ?>
                    <a href="<?php echo URLADM . 'atendimento/arquivado'; ?>">
                        <div class="p-2">
                            <span tabindex="0" data-placement="left" data-toggle="tooltip" title="<?php echo $teste['num_result_arquivado'] . ' - atendimentos arquivados.'; ?>">
                                <button class="btn btn-secondary btn-sm">
                                    Arquivados
                                </button>
                            </span>
                        </div>
                    </a>
                    <?php
                }
                ?>
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

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Nenhum atendimento registrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
        } else {
            ?>


            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <?php
                        if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
                            ?>
                            <th>Empresa</th>
                            <?php
                        }
                        ?>
                        <th>Status</th>
                        <th>Tipo</th>
                        <th class="d-none d-lg-table-cell">Situação</th>
                        <th class="">Empresa</th>
                        <th class="d-none d-lg-table-cell">Descrição</th>
                        <th class="d-none d-lg-table-cell">Data solititação</th>
                        <th class="">Hora de início</th>
                        <th class=""><span tabindex="0" data-placement="left" data-toggle="tooltip" title="Caso a hora atual menos a hora de inicio seja maior que o tempo de execução da atividade, o contador ficará vermelhor e negativo.">Tempo Restante</span>
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
                            <td><span class="badge badge-secondary">Não iniciado</span></td>
                            <td><?php echo $demanda; ?></td>
                            <td>
                                <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="<?php
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
                            <td class="">00/00/00</td>
                            <td class="">00</td>
                            <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <?php
                                            if ($this->Dados['botao']['vis']) { ?>
                                                <a href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id; ?>"
                                                   class="btn btn-info btn-sm my-md-1">Visualizar</a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($this->Dados['botao']['edit']) { ?>
                                                <a href="<?php echo URLADM . 'editar-demanda/edit-demanda/' . $id; ?>"
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
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php if ($this->Dados['botao']['vis_atendimento']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id; ?>">Visualizar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botao']['edit_atendimento']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'editar-demanda/edit-demanda/' . $id; ?>">Editar</a>
                                        <?php } ?>
                                        <?php if (($this->Dados['botao']['can_atendimento']) AND ($id_situacao == 1)) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'cancelar-atendimento/cancelar/' . $id . '?pg='.$this->Dados['pg']; ?>"
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
        ?>


    </div>

</div>
