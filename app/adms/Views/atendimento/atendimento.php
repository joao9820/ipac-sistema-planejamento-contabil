<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//echo $_SESSION['adms_empresa_id'];
//var_dump($this->Dados['arquivado']);
if ($this->Dados['arquivado'][0]) {
    $teste = $this->Dados['arquivado'][0];
    //var_dump($teste);
    //echo $teste['num_result_arquivado'];
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Solicitações</h2>
            </div>
        </div>

        <div class="d-flex">
            <?php
            if ($this->Dados['botao']['abrir_atendimento']) {
                ?>
                <a href="<?php echo URLADM . 'novo-atendimento/novo'; ?>">
                    <div class="p-2 mr-auto">
                        <button class="btn btn-outline-success btn-sm">
                            <i class="far fa-calendar-plus"></i> Nova
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
            <div class="ml-auto">
                <?php
                if ($this->Dados['botao']['ver_arqui_atend']) {
                    ?>
                    <a href="<?php echo URLADM . 'atendimento/arquivado'; ?>">
                        <div class="p-2">
                            <span tabindex="0" data-placement="left" data-toggle="tooltip" title="<?php echo $teste['num_result_arquivado'] . ' - atendimentos arquivados.'; ?>">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-archive"></i> Arquivados
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

        if (empty($this->Dados['listAtendimento'])) {
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
                <table class="table table-striped table-hover border">
                    <thead class="bg-info text-light">
                    <tr>
                        <?php
                        if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
                            ?>
                            <th>Empresa</th>
                            <?php
                        }
                        ?>
                        <th>Tipo</th>
                        <th class="">Situação</th>
                        <th class="d-none d-lg-table-cell">Descrição</th>
                        <th class="d-none d-lg-table-cell">Data</th>
                        <th class="d-none d-lg-table-cell">Hora</th>
                        <th class="text-center">Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php

                    foreach ($this->Dados['listAtendimento'] as $atendimento) {
                        extract($atendimento);

                        ?>

                        <tr>
                            <?php
                                if ($_SESSION['adms_niveis_acesso_id'] <= 3) {
                                    ?>
                                    <td>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true"
                                              title="<?php echo ucwords(strtolower($nome_empresa)) ?>">
                                            <?php echo ucwords(strtolower($fantasia_empresa)); ?>
                                        </span>
                                    </td>
                                    <?php
                                }
                            ?>
                            <td><?php echo $demanda; ?></td>
                            <td>
                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="<?php
                                    if ($id_situacao == 1) {
                                        echo "Seu atendimento foi solicitado. Ele será encaminhado ao setor responsável e seu status será alterado para <span class='text-primary'>Iniciado</span>.";
                                    } elseif ($id_situacao == 2) {
                                        echo "Seu atendimento está agora em andamento assim que for finalizado você será informado.";
                                    }
                                ?>">
                                    <span class="badge badge-<?php echo $cor ?>">
                                        <?php echo $nome_situacao; ?>
                                    </span>
                                </span>

                            </td>
                            <td class="d-none d-sm-table-cell"><?php echo $descricao; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('d/m/Y', strtotime($created)); ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('H:i', strtotime($created)); ?></td>
                            <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <span tabindex="0" data-toggle="tooltip" data-placement="left" title="Visualizar">
                                                <?php
                                                if ($this->Dados['botao']['vis_atendimento']) { ?>
                                                    <a href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id; ?>"
                                                       class="btn btn-info btn-sm my-md-1"><i class="far fa-eye"></i></a>
                                                    <?php
                                                }
                                                ?>
                                            </span>
                                            <?php
                                            if ($this->Dados['botao']['edit_atendimento']) { ?>
                                                <a href="<?php echo URLADM . 'editar-demanda/edit-demanda/' . $id; ?>"
                                                   class="btn btn-warning btn-sm my-md-1">Editar</a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if (($this->Dados['botao']['can_atendimento']) AND ($id_situacao == 1)) { ?>
                                                <span class="d-none d-md-block">
                                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Cancelar">
                                                        <a href="<?php echo URLADM . 'cancelar-atendimento/cancelar/' . $id . '?pg='.$this->Dados['pg']; ?>"
                                                           class="btn btn-outline-danger btn-sm my-md-1"
                                                           data-cancelar='Tem certeza que deseja excluir o atendimento selecionado?'><i class="fas fa-ban"></i></a>
                                                    </span>
                                                </span>
                                            <?php } elseif (($this->Dados['botao']['can_atendimento']) AND ($id_situacao == 4)) {?> 
          
                                                <span tabindex="0" data-placement="left" data-toggle="tooltip" title="Atendimento cancelado.">
                                                    <i class="fas fa-question-circle"></i>
                                                </span>
                                            <?php } else { ?>
                                                <span tabindex="0" data-placement="left" data-toggle="tooltip" title="Atendimento em andamento. Não pode ser cancelado.">
                                                    <i class="fas fa-question-circle"></i>
                                                </span>
                                            <?php
                                            }
                                            ?>
                                            <?php
                                            if (($this->Dados['botao']['arqui_atendimento']) AND (($id_situacao == 3) OR ($id_situacao == 4))) { ?>
                                                <span tabindex="0" data-placement="left" data-toggle="tooltip" title="Somente atendimentos cancelados ou concluídos podem ser arquivados.">
                                                    <a href="<?php echo URLADM . 'arquivar-atendimento/arquivar/' . $id . '?pg='.$this->Dados['pg']; ?>"
                                                       class="btn btn-info btn-sm my-md-1" data-arquivo='Tem certeza que deseja arquivar o atendimento selecionado?'>Arquivar</a>
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
