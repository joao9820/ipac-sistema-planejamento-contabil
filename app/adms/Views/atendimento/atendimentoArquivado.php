<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}

//echo $num_result ."<br>";
//echo $_SESSION['adms_empresa_id'];
//var_dump($this->Dados['listAtendimento']);
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
                <a href="<?php echo URLADM . 'atendimento/listar'; ?>">
                    <div class="p-2">
                        <button class="btn btn-primary btn-sm">
                            Voltar
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>

        </div>

        <?php


        if (isset($_SESSION['msg']))
        {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        if (empty($this->Dados['listAtendimentoArquivado'])) {
            ?>

            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                Nenhum atendimento arquivado!
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

                    foreach ($this->Dados['listAtendimentoArquivado'] as $atendimentoArquivado) {
                        extract($atendimentoArquivado);

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
                                <span tabindex="0" data-toggle="tooltip" data-placement="right" data-html="true" title="<?php
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
                                            <?php
                                            if (($this->Dados['botao']['des_arquiAten']) AND ($id_situacao == 3)) { ?>
                                                <a href="<?php echo URLADM . 'desarquivar-atendimento/aten/' . $id . '?pg='.$this->Dados['pg']; ?>"
                                                   class="btn btn-info btn-sm my-md-1"
                                                   data-desarquivar='Tem certeza que deseja desarquivar o atendimento selecionado?'>
                                                    <i class="fas fa-archive"></i>
                                                </a>
                                            <?php } ?>

                                        </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                            id="acoesListar" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php if ($this->Dados['botao']['des_arquiAten']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'desarquivar-atendimento/aten/' . $id; ?>">
                                                Desarquivar
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

            <?php
        }
        ?>

    </div>

</div>
