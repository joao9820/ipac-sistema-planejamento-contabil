<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/05/2019
 * Time: 16:56
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
    //$idFuncionario = isset($this->Dados['funcionario']['id']) ? $this->Dados['funcionario']['id'] : 0;
    //$NomeFuncionario = isset($this->Dados['funcionario']['nome']) ? $this->Dados['funcionario']['nome'] : "Nome Funcionário";
//var_dump($this->Dados['alocacao']);

extract($this->Dados['url']);
/*
echo $gerente;
echo $data_inicio;
echo $data_fim;
echo $funcionario;
*/
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-12 p-2 d-flex flex-column flex-md-row px-3">
                <h2 class="display-4 titulo">Alocação atividades</h2>

                <span class="d-block ml-auto">
                    <button onclick="window.location.href='<?php echo URLADM . 'alocacao/funcionario/'.$funcionario.'?gerente='.$gerente.'&data_inicio='.$data_inicio.'&data_fim='.$data_fim ?>'" class="btn btn-outline-info btn-sm"><i class="fas fa-arrow-circle-left"></i> Voltar</button>
                </span>
            </div>

            <div class="col-md-6">
                <h3>
                    <small>Funcionário:</small> 
                    <strong class="d-block"><?php echo $this->Dados['funcionarioNome'][0]['nome']; ?></strong>
                </h3>
                <h3>
                    <small>Percentual de Alocação:</small> 
                    <strong class="d-block"><?php echo number_format($this->Dados['percentual_alocacao'], 0, ',', ' ') ?>%</strong>
                </h3>
                <span class="badge bg-light my-3">
                Filtro Aplicado:
                <?php
                echo date("d/m/Y", strtotime($this->Dados['dataFiltro']));
                ?>
                </span>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover border-0">
                        <thead class="border-0">
                        <tr class="">
                            <th>Planejamento</th>
                            <th>Alocação prevista</th>
                            <th>Planejamento Realizado</th>
                            <th>Alocação</th>
                            <th>Atividade</th>
                            <th>Demanda</th>
                            <th style="min-width: 200px">Empresa</th>
                            <th>Status</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach ($this->Dados['alocacao'] as $key => $alocacao) {
                                ?>
                                <tr>
                                    <td>
                                        <?php
                                            echo date('H\hi', strtotime($alocacao['hora_inicio_planejado'])) . " - ";
                                            echo date('H\hi', strtotime($alocacao['hora_fim_planejado']));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo date('H:i:s', strtotime($alocacao['duracao_atividade']));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        echo date('H\hi', strtotime($alocacao['inicio_atendimento'])) . " - ";
                                        echo date('H\hi', strtotime($alocacao['fim_atendimento']));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            /*
                                                // Converter para segundos, o tempo excedido ou restante
                                                if (!empty($alocacao['at_tempo_restante'])) {
                                                    $restante = date('H:i:s', strtotime($alocacao['at_tempo_restante']));
                                                    $partes = explode(':', $restante);
                                                    $tempoRestante = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                                } else {
                                                    $tempoRestante = null;
                                                }

                                                if (!empty($alocacao['at_tempo_excedido'])) {
                                                    $excedido = date('H:i:s', strtotime($alocacao['at_tempo_excedido']));
                                                    $partes = explode(':', $excedido);
                                                    $tempoExcedido = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                                } else {
                                                    $tempoExcedido = null;
                                                }


                                                if (!empty($alocacao['duracao_atividade'])) {
                                                    $duracao = date('H:i:s', strtotime($alocacao['duracao_atividade']));
                                                    $partes = explode(':', $duracao);
                                                    $duracaoAtividade = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                                                } else {
                                                    $duracaoAtividade = null;
                                                }

                                                // Calculando alocação
                                                if ($tempoRestante != null){
                                                    $alocacaoReal = $duracaoAtividade - $tempoRestante;
                                                } else {
                                                    if ($tempoExcedido != null) {
                                                        $alocacaoReal = $duracaoAtividade + $tempoExcedido;
                                                    } else {
                                                        $alocacaoReal = $duracaoAtividade;
                                                    }
                                                }
                                                $alocacaoAtividade = gmdate('H:i:s', $alocacaoReal);
                                            */

                                            echo date('H:i:s', strtotime($alocacao['alocacao_atividade']));
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $alocacao['nome_atividade']; ?>
                                    </td>
                                    <td>
                                        <?php echo $alocacao['nome_demanda']; ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo $alocacao['nome_empresa'];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo '<span class="badge badge-'.$alocacao['cor_sit_aten_func'].'">';
                                            echo $alocacao['nome_sits_aten_func'];
                                            echo '</span>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo "ver";
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

