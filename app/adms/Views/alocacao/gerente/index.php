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
?>


<div class="content p-1">
    <div class="list-group-item">
        <div class="row">
            <div class="col-md-12 p-2 d-flex px-3">
                <h2 class="display-4 titulo">Alocação funcionários</h2>

                <span class="d-block ml-auto">
                    <button onclick="window.location.href='<?php echo URLADM . 'alocacao/listar'; ?>'" class="btn btn-outline-info btn-sm"><i class="fas fa-arrow-circle-left"></i> Voltar</button>
                </span>
            </div>

            <div class="col-md-6">
                <h3>Nome do Gerente</h3>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <form method="post" action="" class="form-inline my-1">
                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data início">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataInicial" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2">
                        </div>
                    </span>

                    <span class="mr-2">até</span>

                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data fim">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="dataFinal" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2" required>
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
                        <?php
                            $dados = [
                                ['nome'=>'Marcelo', 'funcao'=>'Contador', 'alocacao'=>'90'],
                                ['nome'=>'Virginia', 'funcao'=>'Contador', 'alocacao'=>'110'],
                                ['nome'=>'Odilene', 'funcao'=>'Analista', 'alocacao'=>'95']
                            ];
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
                                foreach ($dados as $key => $dado){
                                    echo '<tr>';
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
                                    echo '<td><button class="btn btn-outline-secondary"><i class="fas fa-external-link-square-alt"></i></button></td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
            </div>
        </div>

    </div>
</div>

