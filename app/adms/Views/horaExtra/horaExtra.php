<?php

if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>
<?php
//var_dump($this->Dados);
if (!empty($this->Dados['funcionario'][0])) {
    extract($this->Dados['funcionario'][0]);
}
if (!empty($this->Dados['funcionario'])) {
    extract($this->Dados['funcionario']);
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Hora Extra - <?php echo $nome_funcionario ?></h2>
            </div>
            <div class="d-flex p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'jornada-de-trabalho/listar'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar Funcionários</a>
                </span>
                <span class="d-block ml-2">
                    <a href="<?php echo URLADM . 'editar-jornada-de-trabalho/editar/' . $id_funcionario; ?>"
                       class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i> Editar Funcionário</a>
                </span>
            </div>
        </div>
    </div>
    <div class="list-group-item border mx-4 mb-4 p-0 rounded">
        <div id="headerDescricaoPg" class="bg-primary">
            <h3 class="">Agendando hora extra</h3>
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
                <div class="col-12 my-4">
                    <form method="post" action="" class="form-inline">
                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Agendar hora extra para o funcionário">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="far fa-calendar-plus"></i>
                                    </div>
                                </div>
                                <input name="data" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" min="<?php echo date('Y-m-d');?>" class="form-control" id="inlineFormInputGroupUsername2" required>
                            </div>
                        </span>


                        <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Defina o total de hora extra">
                            <div class="input-group mb-2 mr-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-stopwatch"></i>
                                    </div>
                                </div>
                                <input name="total" type="time" class="form-control" id="horaExtraTotal" required>
                            </div>
                        </span>


                        <button type="submit" class="btn btn-outline-success mb-2"><i class="far fa-plus-square"></i> Agendar</button>
                    </form>
                </div>
            </div>
        </div>

        <hr>
            <h4 class="text-secondary mr-2">Filtrar por data: </h4>
            <form method="post" action="" class="form-inline">



                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Caso não escolha uma data inicial será considerado a data atual">
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

                <span tabindex="0" data-toggle="tooltip" data-placement="top" data-html="true" title="Data final">
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                        </div>
                        <input name="dataFinal" type="date" pattern="[0-9]{2}\/[0-9]{2}\/[0-9]{4}$" class="form-control" id="inlineFormInputGroupUsername2" required>
                    </div>
                </span>

                <button type="submit" class="btn btn-outline-warning mb-2 mr-2"><i class="fas fa-search"></i> Filtrar</button>
                <a href="<?php echo URLADM . 'hora-extra/listar/1?func=' .$id_funcionario ?>" class="btn btn-outline-secondary mb-2"><i class="fas fa-eraser"></i> Limpar Filtro</a>
            </form>

        <?php
        if (empty($this->Dados['horasExtraListar'])) {
            ?>

            <div class="alert alert-secondary alert-dismissible text-center py-5 fade show" role="alert">
                Nenhum histórico de agendamento de hora extra encontrado para esse funcionário!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
        } else
            {

            ?>



            <div class="table-responsive">
                <table class="table table-striped table-hover table-border">
                    <thead class="bg-info text-light">
                    <tr>
                        <th class="">Data</th>
                        <th class="">Hora Extra</th>
                        <th class="text-center">Ações</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php

                    if (!empty($this->Dados['horasExtraListar'])) {
                        foreach ($this->Dados['horasExtraListar'] as $horaExtra) {
                            extract($horaExtra);

                            ?>

                        <tr>
                            <td><?php echo date('d/m/Y', strtotime($data)); ?></td>
                            <td><?php echo date('H:i', strtotime($total)); ?></td>
                            <td class="text-right">

                                <a href="<?php echo URLADM . 'hora-extra/deletar/1?func=' .$id_funcionario .'&he='. $id_hora_extra ?>" class="btn btn-outline-danger mb-2"
                                   data-confirmAgendar='Deletar?'>
                                    <i class="fas fa-trash"></i>
                                </a>

                            </td>
                        </tr>

                        <?php
                        }
                    } else {
                        echo "Ainda não existe hora extra para esse funcionário";
                    }
                    ?>


                    </tbody>

                </table>

                <?php
                if(!empty($this->Dados['paginacao'])){
                   echo $this->Dados['paginacao']; 
                }
                

                ?>

            </div>


            <?php
        }
         ?>


    </div>

    </div>

</div>
