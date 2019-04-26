<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/04/2019
 * Time: 13:49
 */
//var_dump($this->Dados['funcionarioPlan']);
extract($this->Dados['funcionarioPlan'][0])
?>
<style>
    .table thead th {
        font-weight: 400;
    }
    .table td, .table th {
        border-top: none;
    }
    .titulo {
        margin-bottom: 0 !important;
    }
    #jornadaDuracaoLivre {
        font-size: 1.5em;
    }

</style>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo"><i class="far fa-calendar-alt"></i> Planejamento do Funcionario "<strong><?php echo ucfirst($nome_funcionario); ?></strong>"</h2>
                <h4 class="mt-1 text-secondary mb-5"><sup>Para o dia:</sup> <?php
                    echo date('d/m/Y', strtotime($_GET['data']));
                    ?>
                </h4>
                <span class="d-block mt-3">
                    <a href="<?php echo URLADM . 'atendimento-funcionarios/listar/'.$_GET['demanda'].'?aten='.$_GET['aten']; ?>" class="btn btn-outline-primary btn-sm"><i class="fas fa-arrow-left"></i> Voltar</a>
                </span>
            </div>
        </div>
    </div>
    <div class="list-group-item border mx-4 mb-4 p-0 rounded">
        <div id="headerDescricaoPg" class="bg-primary">
            <h3 class="">Funcionário: <?php echo ucfirst($nome_funcionario); ?></h3>
        </div>

        <div class="list-group-item">
            <?php
            if(isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }

            ?>

            <div class="container-fluid">
                <div class="row">


                </div>
            </div>

            <div class="row">

                <div class="col-md-12 mb-4">
                    <?php
                    if (empty($this->Dados['verPlanFunc'])) {
                        ?>

                        <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                            Nenhum planejamento encontrado!
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <?php
                    } else {
                        //var_dump($this->Dados['verPlanFunc']);
                        ?>



                        <div class="table-responsive">
                            <table class="table table-striped table-hover border-0">
                                <thead class="border-0">
                                <tr>
                                    <th class="">ID Atendimento</th>
                                    <th>Descrição Atendimento</th>
                                    <th class="">Demanda</th>
                                    <th class="">Atividade</th>
                                    <th class="">Duração atividade</th>
                                    <th class="">Data inicio planejado</th>
                                    <th class="">Hora inicio planejado</th>
                                    <th class="">Data Fatal</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $contFor = 0;
                                if (!empty($this->Dados['verPlanFunc'])) {
                                foreach ($this->Dados['verPlanFunc'] as $atenFuncPlan) {
                                extract($atenFuncPlan);

                                ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo $id_atendimento;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $descricao_atendimento;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $nome_demanda;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $nome_atividade;
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo date('H\hi', strtotime($duracao_atividade));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo date('d/m/Y', strtotime($data_inicio_planejado));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo date('H\hi', strtotime($hora_inicio_planejado));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo date('d/m/Y', strtotime($data_fatal));
                                        ?>
                                    </td>

                                </tr>

                                <?php
                                    } // Fim foreach
                                }
                                ?>


                                </tbody>

                            </table>
                            <div id="jornadaDuracaoLivre" class="d-flex flex-row justify-content-end mt-5">
                                <?php
                                    //var_dump($this->Dados['jornadaTrabalho'][0]);
                                    extract($this->Dados['jornadaTrabalho'][0]);
                                    extract($this->Dados['atividadesDuracao'][0]);
                                ?>
                                <div class="mr-3" tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Refere-se a jornada de trabalho deste funcionário. Já incluso hora extra caso tenha disponível para a data acima selecionada."><small>Jornada de trabalho:</small>
                                    <strong class="text-secondary">
                                        <?php
                                            echo date('H\hi', strtotime($jornada_trabalho));
                                        ?>
                                    </strong>
                                </div>
                                <div class="mr-3" tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Essa duração é calculada com a soma da duração de cada uma das atividades acima."><small>Duração atividades:</small>
                                    <strong class="text-warning">
                                        <?php
                                            echo date('H\hi', strtotime($duracao_atividade));
                                        ?>
                                    </strong>
                                </div>
                                <div class="mr-2" tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Refere-se ao tempo disponível para atribuir atividade ao funcionário."><small>Tempo disponível:</small>

                                        <?php

                                        $partes = explode(':', $jornada_trabalho);
                                        $segundosJornada = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];

                                        $partes = explode(':', $duracao_atividade);
                                        $segundosAtividades = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];

                                        if ($segundosJornada > $segundosAtividades) {
                                            echo '<strong class="text-success">';
                                            $resultado = $segundosJornada - $segundosAtividades;
                                            echo gmdate("H\hi",$resultado);
                                            echo '</strong>';
                                        } else {
                                            echo '<strong class="text-danger">';
                                            $resultado = $segundosAtividades - $segundosJornada;
                                            echo "-" . gmdate("H\hi",$resultado);
                                            echo '</strong>';
                                        }

                                        ?>
                                </div>
                            </div>

                            <?php

                            //echo $this->Dados['paginacao'];

                            ?>

                        </div>


                        <?php
                    }
                    ?>
                </div>

            </div>

        </div>

    </div>

</div>

