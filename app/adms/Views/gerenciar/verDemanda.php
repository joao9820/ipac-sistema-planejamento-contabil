<?php

if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>
<?php
//var_dump($this->Dados);
if(!empty($this->Dados['dados_demanda'][0]))
{
extract($this->Dados['dados_demanda'][0]);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Ver Demanda</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                   <?php
                   if ($this->Dados['botao']['list_demanda']) {
                       echo "<a href='" . URLADM . "demandas/listar' class='btn btn-info btn-sm'>Listar</a> ";
                   }
                   if ($this->Dados['botao']['edit_demanda']) {
                       echo "<a href='" . URLADM . "editar-demanda/edit-demanda/$id' class='btn btn-warning btn-sm'>Editar</a> ";
                   }
                   if ($this->Dados['botao']['del_demanda']) {
                       echo "<a href='" . URLADM . "apagar-demanda/apagar-demanda/$id' class='btn btn-danger btn-sm' data-confirmDema='Tem certeza que deseja excluir a demanda selecionada e todas as atividades nela cadastrada?'>Apagar</a> ";
                   }
                   ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->Dados['botao']['list_demanda']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "demandas/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['edit_demanda']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "editar-demanda/edit-demanda/$id'>Editar</a>";
                        }
                        if ($this->Dados['botao']['del_demanda']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-demanda/apagar-demanda/$id' data-confirmDema='Tem certeza que deseja excluir a demanda selecionada e todas as atividades nela cadastrada?'>Apagar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>

        <hr>

        <dl class="row">
                    <dt class="col-sm-3">Nome:</dt>
                    <dd class="col-sm-9"><?php echo $nome ?></dd>

                    <dt class="col-sm-3">Descricao:</dt>
                    <dd class="col-sm-9"><?php echo $descricao ?></dd>

                    <dt class="col-sm-3">Cadastrada por:</dt>
                    <dd class="col-sm-9"><?php echo $nome_usuario ?></dd>

                    <dt class="col-sm-3">Inserido:</dt>
                    <dd class="col-sm-9"><?php echo date('d-m-Y H:i', strtotime($created)); ?></dd>

                    <dt class="col-sm-3">Alterado:</dt>
                    <dd class="col-sm-9"><?php
                        if (!empty($modified)) {
                            echo date('d-m-Y H:i', strtotime($modified));
                        }
                        ?>
                    </dd>
                    <dt class="col-sm-3">Tempo de execução:</dt>
                    <dd class="col-sm-9">
                        <?php
                            if ($this->Dados['totalHorasAtividades'][0]) {
                                //var_dump($this->Dados['totalHorasAtividades'][0]);
                                extract($this->Dados['totalHorasAtividades'][0]);

                                if (isset($total_horas)) {

                                    $dadosHoras = (string)$total_horas;
                                    $dados = explode(":", $dadosHoras);

                                    $hora = $dados[0];
                                    $minuto = $dados[1];


                                    if ($hora >= 24) {
                                        $dia = (int)($hora / 24);
                                        if ($dia > 1) {
                                            echo $dia . " dias";
                                        } else {
                                            echo $dia . " dia";
                                        }

                                        if ($hora != 24) {
                                            if ($minuto > 0) {
                                                echo ", ";
                                            } else {
                                                echo " e ";
                                            }
                                            $novaHora = $hora - ($dia * 24);
                                            if ($novaHora > 1) {
                                                echo $novaHora . " horas";
                                            } else {
                                                echo $novaHora . " hora";
                                            }

                                        }

                                        if ($minuto != 0) {
                                            echo " e ";
                                            if ($minuto == 1) {
                                                echo $minuto . " minuto.";
                                            } else {
                                                echo $minuto . " minutos.";
                                            }
                                        }

                                    } else {

                                        if ($hora == 1) {
                                            echo $hora . " hora";
                                        } elseif ($hora > 1) {
                                            echo $hora . " horas";
                                        }


                                        if ($minuto != 0) {
                                            if (($minuto == 1) AND $hora == 00) {
                                                echo $minuto . " minuto";
                                            } elseif (($minuto != 1) AND ($hora == 00)) {
                                                echo $minuto . " minutos";
                                            }
                                            if (($minuto == 1) AND ($hora != 00)) {
                                                echo " e " . $minuto . " minuto";
                                            } elseif (($minuto != 1) AND ($hora != 00)) {
                                                echo " e " . $minuto . " minutos";
                                            }
                                        }
                                        echo ".";

                                    }
                                }
                            }
                        ?>
                    </dd>
        </dl>
        <div class="p-2">
                <span class="my-3">

                           <?php
                           if ($this->Dados['botaoAtividade']['cad_atividade']) { ?>
                               <a href="<?php echo URLADM . 'cadastrar-atividade/cad-atividade/' . $id; ?>"
                                  class="btn btn-success btn-sm my-md-1">Cadastrar</a>
                               <?php
                           }
                           ?>
                </span> Atividade
        </div>


        <?php
        if (empty($this->Dados['atividades'])) {
            ?>

            <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                Nenhuma atividade cadastrada!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
        } else
            {
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>



            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                    <tr>
                        <th class="">Ordem</th>
                        <th class="">Atividade</th>
                        <th class="d-none d-lg-table-cell">Descrição</th>
                        <th class="d-none d-lg-table-cell">Duração</th>
                        <th class="text-center">Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php

                    foreach ($this->Dados['atividades'] as $atividade) {
                        extract($atividade);

                        ?>

                        <tr>
                            <td><?php echo $ordem; ?></td>
                            <td><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $descricao; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo date('H:i',strtotime($duracao)); ?></td>
                            <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <?php
                                            if ($this->Dados['botaoAtividade']['vis_atividade']) { ?>
                                                <a href="<?php echo URLADM . 'ver-atividade/ver-atividade/' . $id; ?>"
                                                   class="btn btn-info btn-sm my-md-1">Visualizar</a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($this->Dados['botaoAtividade']['edit_atividade']) { ?>
                                                <a href="<?php echo URLADM . 'editar-atividade/edit-atividade/' . $id; ?>"
                                                   class="btn btn-warning btn-sm my-md-1">Editar</a>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                            if ($this->Dados['botaoAtividade']['del_atividade']) { ?>
                                                <a href="<?php echo URLADM . 'apagar-atividade/apagar-atividade/' . $id; ?>"
                                                   class="btn btn-danger btn-sm my-md-1"
                                                   data-confirm='Tem certeza que deseja excluiro item selecionado?'>Apagar</a>
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
                                        <?php if ($this->Dados['botaoAtividade']['vis_atividade']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'ver-atividade/ver-atividade/' . $id; ?>">Visualizar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botaoAtividade']['edit_atividade']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'editar-atividade/edit-atividade/' . $id; ?>">Editar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botaoAtividade']['del_atividade']) { ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'apagar-atividade/apagar-atividade/' . $id; ?>"
                                               data-confirm='Tem certeza que deseja excluiro item selecionado?'>Apagar</a>
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

                //echo $this->Dados['paginacao'];

                ?>

            </div>


            <?php
        }
         ?>


    </div>

</div>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Nenhuma demanda encontrado!</div>";
    $UrlDestino = URLADM .'demandas/listar';
    header("Location: $UrlDestino");
}
?>
