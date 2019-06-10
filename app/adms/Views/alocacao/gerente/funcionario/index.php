<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 20/05/2019
 * Time: 12:46
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (isset($this->Dados['funcionario'])){
    $idFuncionario = isset($this->Dados['funcionario']['id']) ? $this->Dados['funcionario']['id'] : 0;
    $NomeFuncionario = isset($this->Dados['funcionario']['nome']) ? $this->Dados['funcionario']['nome'] : "Nome Funcionário";
}
if (!empty($this->Dados['dadosForm'])){
    extract($this->Dados['dadosForm']);
    //echo $dataInicial;
    //echo $dataFinal;
}

?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-12 p-2 d-flex px-3">
                <h2 class="display-4 titulo">Alocação atividades</h2>

                <span class="d-block ml-auto">
                    <button onclick="window.location.href='<?php echo URLADM . 'alocacao/gerente/' . $_GET['gerente'].'?data_inicio='.$dataInicial.'&data_fim='.$dataFinal; ?>'" class="btn btn-outline-info btn-sm"><i class="fas fa-arrow-circle-left"></i> Voltar</button>
                </span>
            </div>

            <div class="col-md-6">
                <h3><?php echo $NomeFuncionario; ?></h3>

            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover border-0">
                        <thead class="border-0">
                        <tr>
                            <th>Data</th>
                            <th>Alocação</th>
                            <th>Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if (!empty($this->Dados['alocacao'])){
                            foreach ($this->Dados['alocacao'] as $Data => $Value){
                                $JorTra = (int) $Value['JornadaTrabalho'];
                                $DurAti = (int) $Value['DuracaoAtividades'];
                                // Calcular porcentagem de alocação
                                $AlocacaoT =  ($DurAti / $JorTra) * 100;
                                $textoCor = $AlocacaoT > 100 ? "text-danger" : "text-secondary";
                                ?>
                                <tr class="<?php echo $textoCor; ?>">
                                    <td><?php echo date('d/m/Y', strtotime($Data)); ?></td>
                                    <td>
                                        <strong>
                                            <?php echo number_format($AlocacaoT, 0, ',', ' ') . "%"; ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <i onclick="window.location.href='<?php echo URLADM . 'alocacao/funcionarioData/'.$idFuncionario.'?data='.$Data.'&data_inicio='.$_GET['data_inicio'].'&data_fim='.$_GET['data_fim'].'&gerente='.$_GET['gerente'] ?>'" class="fas fa-external-link-square-alt fa-2x" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                                <?php
                                }
                            }// fim do if
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
