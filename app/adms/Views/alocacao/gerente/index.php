<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 09/05/2019
 * Time: 12:40
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados['listarAtenFunc']);
if (isset($this->Dados['gerente'])){
    $idGerente = isset($this->Dados['gerente']['id']) ? $this->Dados['gerente']['id'] : 0;
    $NomeGerente = isset($this->Dados['gerente']['nome']) ? $this->Dados['gerente']['nome'] : "Nome gerente";
}
// pega a data de inicio e fim
$DataInicio = isset($this->Dados['DataInicio']) ? $this->Dados['DataInicio'] : date('Y-m-d');
$DataFim = isset($this->Dados['DataFim']) ? $this->Dados['DataFim'] : date('Y-m-d');

if (!empty($this->Dados['dadosForm'])){
    extract($this->Dados['dadosForm']);
}
?>


<div class="content p-1">
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-12 p-2 d-flex flex-column flex-md-row px-3">
                <h2 class="display-4 titulo">Alocação funcionários</h2>

                <span class="d-block ml-auto">
                    <button onclick="window.location.href='<?php echo URLADM . 'alocacao/listar?data_inicio='.$DataInicio.'&data_fim='.$DataFim; ?>'" class="btn btn-outline-info btn-sm"><i class="fas fa-arrow-circle-left"></i> Voltar</button>
                </span>
            </div>

            
            <div class="col-md-12 d-flex justify-content-center justify-content-md-end">
                <form id="FiltroBusca" method="post" action="" class="d-flex flex-column flex-md-row my-1">
                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data início">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend displayNone">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataInicial" type="date" value="<?php echo isset($dataInicial) ? $dataInicial : ""; ?>" class="form-control" id="inlineFormInputGroupUsername2">
                        </div>
                    </span>

                    <span class="mx-2">até</span>

                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data fim">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend displayNone">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataFinal" type="date" value="<?php echo isset($dataFinal) ? $dataFinal : ""; ?>"  class="form-control" id="inlineFormInputGroupUsername2" required>
                        </div>
                    </span>

                    <span class="ml-0 ml-md-2">
                        <button class="btn btn-outline-powercar mb-2 mr-2"><i class="fas fa-search"></i></button>
                    </span>
                </form>
            </div>

            <div class="col-md-6 text-left my-2 my-md-0">
                <h3><small>Gerente:</small> <strong class="d-block"><?php echo $NomeGerente; ?></strong></h3>
            </div>

        </div>

        <div class="row mt-3">
            <div class="col-md-6 text-center text-md-left">
                <span class="badge bg-light my-3">
                Filtro Aplicado:
                <?php
                    echo date("d/m/Y", strtotime($DataInicio));
                    echo " - ";
                    echo date("d/m/Y", strtotime($DataFim));
                ?>
                </span>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover border-0">
                        <?php
                            //var_dump($this->Dados['alocacao']);
                            $dados = $this->Dados['alocacao'];
                        ?>
                        <thead class="border-0">
                            <tr>
                                <th>Funcionário</th>
                                <th>Função</th>
                                <th>Alocação</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($dados as $key => $value){

                                    $DurAti = (int)  $value['duracao_atividade_sc'];
                                    $JorTra = (int) $value['duracao_total_jornada'];
                                    // Calcular porcentagem de alocação
                                    $AlocacaoT = $DurAti > 0 ? ($DurAti / $JorTra) * 100 : 0;
                                    $textoCor = $AlocacaoT > 100 ? "text-danger" : "text-secondary";

                                    echo '<tr>';
                                        echo "<td>{$value['nome']}</td>";
                                        echo "<td>{$value['cargo']}</td>";
                                        echo "<td class='".$textoCor."'><strong>". number_format($AlocacaoT, 0, ',', ' ') ."%</strong></td>";

                                    /*
                                    foreach ($dado as $coluna => $item){
                                        if ($coluna == "alocacao"){ // quando a coluna é alocação exibir o simbolo de %
                                            if ($item > 100){ // quando a alocação for maior que 100% exibir em vermelhor
                                                echo "<td class='text-danger'><strong>" . $item . "%</strong></td>";
                                            } else {
                                                echo "<td><strong>" . $item . "%</strong></td>";
                                            }
                                        } else {
                                            echo "<td>" . $item . "</td>"; // exibir os demais itens
                                        }
                                    }
                                    */
                                    ?>
                                    <td>
                                        <button onclick="window.location.href='<?php echo URLADM . 'alocacao/funcionario/'.$value['id'].'?gerente='.$idGerente.'&data_inicio='.$DataInicio.'&data_fim='.$DataFim; ?>'" class="btn btn-outline-secondary">
                                            <i class="fas fa-external-link-square-alt"></i>
                                        </button>
                                    </td>
                            <?php
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>

    </div>
</div>

