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
            <div class="col-md-12 p-2 d-flex px-3">
                <h2 class="display-4 titulo">Alocação atividades</h2>

                <span class="d-block ml-auto">
                    <button onclick="window.location.href='<?php echo URLADM . 'alocacao/funcionario/'.$funcionario.'?gerente='.$gerente.'&data_inicio='.$data_inicio.'&data_fim='.$data_fim ?>'" class="btn btn-outline-info btn-sm"><i class="fas fa-arrow-circle-left"></i> Voltar</button>
                </span>
            </div>

            <div class="col-md-6">
                <h3>Funcionário: <?php echo $this->Dados['funcionarioNome'][0]['nome']; ?></h3>
                <h3>Percentual de Alocação: <?php echo number_format($this->Dados['percentual_alocacao'], 1, ',', ' ') ?>%</h3>
                <span class="badge bg-light my-3">
                Filtro Aplicado:
                <?php
                echo date("d/m/Y", strtotime($this->Dados['dataFiltro']));
                ?>
                </span>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <form method="post" action="" class="form-inline my-1">
                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataInicial" type="date" value="<?php echo $this->Dados['dataFiltro'] ?>" class="form-control" id="inlineFormInputGroupUsername2">
                        </div>
                    </span>
                    <button class="btn btn-outline-warning mb-2 mr-2"><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover border-0">
                        <thead class="border-0">
                        <tr>
                            <th>Planejamento</th>
                            <th>Alocação</th>
                            <th>Empresa</th>
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
                                            echo date('H:i', strtotime($alocacao['hora_inicio_planejado'])) . " - ";
                                            echo date('H:i', strtotime($alocacao['hora_fim_planejado']));
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            echo date('H\hi', strtotime($alocacao['duracao_atividade']));
                                        ?>
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

