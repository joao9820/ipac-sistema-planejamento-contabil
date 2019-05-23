<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>

<style>
    .dataAtendimento .legenda {
        font-size: .8em;
    }
    .dataAtendimento .data {
        border: 1px solid rgba(0,0,0,0.125);
        border-radius: 5px;
        padding: 2px 4px;
    }

</style>
<?php
//var_dump($this->Dados);
//die();
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">

            </div>
            <div class="d-flex p-2">
               <span class="d-block">
                    <a href="<?php echo URLADM . 'gerenciar-atendimento/listar/1'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar atendimentos</a>
                </span>
            </div>
        </div>
    </div>
    <div class="list-group-item border mx-4 mb-4 p-0 rounded">
        <div id="headerDescricaoPg" class="bg-primary">
            <h3 class="">Listando Atividades</h3>
        </div>

        <div class="list-group-item">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>

            <hr>
            <h4 class="text-secondary mr-2">Filtrar Dados: </h4>
            <form method="GET" action="<?php echo URLADM . 'verificar-atividades/listar/1' ?>">
                <div class="form-inline">
                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Caso não escolha uma data inicial será considerado a data atual">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="data_inicio" type="date" value="<?php $data_inicio = isset($this->Dados['dataInicial']) ? $this->Dados['dataInicial'] : date('Y-m-d');
            echo $data_inicio
            ?>" class="form-control" id="inlineFormInputGroupUsername2">
                        </div>
                    </span>


                    <span class="mr-2">até</span>

                    <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data final">
                        <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                            </div>
                            <input name="data_fim" type="date" value="<?php $data_fim = isset($this->Dados['dataFinal']) ? $this->Dados['dataFinal'] : null;
                                   echo $data_fim
            ?>" class="form-control" id="inlineFormInputGroupUsername2">
                        </div>
                    </span>
                </div>
                <div class="form-inline">


                    <div class="col-md-3 input-group mb-2 mr-sm-2 p-0">

                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-demanda_id">
                                <i class="fas fa-clipboard-list"></i>
                            </span>
                        </div>
                        <select name="dem" id="adms_demanda_id" class="form-control" aria-describedby="basic-demanda_id">
                            <option value="">Demanda</option>
                            <?php
                            foreach ($this->Dados['demandas'] as $demanda) {
                                extract($demanda);

                                if (filter_input(INPUT_GET, "dem", FILTER_DEFAULT) == $id) {
                                    echo "<option value='$id' selected>$nome</option>";
                                } else {
                                    echo "<option value='$id'>$nome</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>         
                    <?php
                    if (isset($this->Dados['empresas'])) {
                        ?>
                        <!-- Apenas o gerente pode visualizar essa parte de selecionar empresa -->

                        <div class=" col-md-3 input-group mb-2 mr-sm-2 p-0">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-empresaid">
                                    <i class="fas fa-building"></i>
                                </span>
                            </div>

                            <select name="emp" id="adms_empresa_id" class="form-control" aria-describedby="basic-empresaid">
                                <option value="">Empresa</option>
                                <?php
                                foreach ($this->Dados['empresas'] as $empresa) {
                                    extract($empresa);
                                    if (filter_input(INPUT_GET, "emp", FILTER_DEFAULT) == $id_empresa) {
                                        echo "<option value='$id_empresa' selected>$nome_empresa</option>";
                                    } else {
                                        echo "<option value='$id_empresa'>$nome_empresa</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <?php
                    }
                    ?>
                </div>    
                <button type="submit" class="btn btn-outline-warning mb-2 mr-2" name="filtro" value="filtroAtivo"><i class="fas fa-search"></i> Filtrar</button>
                <a href="<?php echo URLADM . 'verificar-atividades/listar' ?>" class="btn btn-outline-secondary mb-2"><i class="fas fa-eraser"></i> Limpar Filtro</a>


            </form>

            <?php
            if (empty($this->Dados['listaAtividades']) && isset($_SESSION['erro_filtro'])) {
                ?>
                <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                    Nenhuma Atividade foi encontrada, limpe o filtro e tente novamente
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
            } else if (empty($this->Dados['listaAtividades'])) {
                ?>

                <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                    Nenhuma Atividade foi encontrada
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php
            } else {
                ?>


                <div class="table-responsive">
                    <table class="table table-striped table-hover table-border">
                        <thead class="bg-info text-light">
                            <tr>
                                <th class="text-center">Cod. Atend.</th>
                                <th class="text-center">Demanda</th>
                                <th class="text-center">Empresa</th>
                                <th class="text-center">Funcionário</th>
                                <th class="text-center">Atividade</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Duração</th>
                                <th class="text-center">Data de Inicio</th>
                                <th class="text-center">Data Fatal</th>  
                                <th class="text-center">Ações</th> 
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($this->Dados['listaAtividades'])) {
                                foreach ($this->Dados['listaAtividades'] as $atividades) {
                                    extract($atividades);
                                    ?>
                                    <tr class="">
                                        <td class="d-none d-lg-table-cell text-center <?php if (($data_fatal < date('Y-m-d'))and (!empty($data_fatal)) and $aten_sit != 4) {
                                            echo "text-danger";
                                        } else {
                                            echo "text-dark";
                                        } ?>">
                                            <?php
                                            
                                            if (($data_fatal < date('Y-m-d'))and (!empty($data_fatal)) and $aten_sit != 4){
                                                echo "<span class='luzAlert' tabindex='0' data-placement='right' data-toggle='tooltip' title='Atividade Atrasada.'>";
                                                echo '<span class="text-danger">';
                                                    echo '<i class="fas fa-lightbulb faIpac"></i>';
                                                echo '</span>';
                                                echo "</span>";  
                                            }else{
                                                if($aten_sit == 4){
                                                  echo "<span class='luzAlert' tabindex='0' data-placement='right' data-toggle='tooltip' title='Atividade Concluída.'>";  
                                                }else{
                                                    echo "<span class='luzAlert' tabindex='0' data-placement='right' data-toggle='tooltip' title='Atividade no Prazo.'>";
                                                }
                                                
                                                echo '<i class="fas fa-lightbulb text-light faIpac"></i>';
                                                echo "</span>";
                                            } 
                                        ?>
                                        <?php
                                            if ($adms_atendimento_id < 10){
                                                echo "000".$adms_atendimento_id;
                                            } elseif ($adms_atendimento_id < 100){
                                                echo "00".$adms_atendimento_id;
                                            } elseif ($adms_atendimento_id < 100){
                                                echo "0".$adms_atendimento_id;
                                            } else {
                                                echo $adms_atendimento_id;
                                            }
                                        ?>
                                            
                                        <!--Incluir luzes de alerta de litarAtendimentos.php -->
                                        </td>
                                        <td class="text-center"><?php echo $nome_demanda ?></td>
                                        <td class="text-center"><?php echo $fantasia ?></td>
                                        <td class="text-center"><?php echo $nome_func ?></td>
                                        <td class="text-center"><?php echo $nome_atv ?></td>
                                        <td class="text-center">
                                            <?php
                                            if (!empty($descricao)) {
                                                ?>
                                                <span tabindex="0" data-placement="top" data-toggle="tooltip" title="<?php echo $descricao; ?>">
                                                    <i class="far fa-file-alt"></i>
                                                </span>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td class="text-center">

                                            <span class="badge badge-<?php echo $cor ?>">
                                                <?php echo $nome_sit ?>
                                            </span>

                                        </td>

                                        <td class="text-center"><?php echo $duracao_atividade ?></td>
                                        <td>
                                            <div class="dataAtendimento text-center">
                                                <span class="data bg-light text-secondary shadow"><i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y', strtotime($data_inicio_planejado)); ?></span>
                                            </div>
                                        </td>

                                        <td class="text-center"><?php echo date('d/m/Y', strtotime($data_fatal)) ?></td>
                                        <td class="text-center">
                                            <?php if ($this->Dados['botao']['vis_atendimento']) { ?>
                                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Visualizar">
                                                    <a href="<?php echo URLADM . 'atendimento-funcionarios/listar/' . $id . '?aten=' . $adms_atendimento_id ?>" class="btn btn-outline-primary btn-sm my-md-1" target="_blank">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </span>
                                                <?php
                                            }
                                            ?> 
                                        </td>
                                    </tr>

                                    <?php
                                }
                            } else {
                                echo "Ainda não existe nenhuma Atividade cadastrada nos Atendimentos";
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

</div>
