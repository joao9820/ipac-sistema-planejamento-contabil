<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/01/2019
 * Time: 16:51
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
//var_dump($this->Dados)
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Histórito de Atividade do Atendimento</h2>
            </div>
            <?php

            if ($this->Dados['botao']['vis_atendimento']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'atendimento-gerente/ver/' . $this->Dados['id_atendimento']. '?pg='.$this->Dados['pg']; ?>" class="btn btn-info btn-sm my-md-1">Visualizar</a>
                </div>
                <?php
            }
            ?>
        </div>



        <?php
        if (empty($this->Dados['logsAtendimento'])) {
            ?>

            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                Oops! atendimento sem histórico registrado!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php
        } else {

        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>


        <div class="table-responsive col-12 col-md-6">
            <table class="table table-striped table-hover ">
                <thead>
                <tr>
                    <th class="">Histórico</th>
                    <th class="">Data</th>
                    <th class="">Hora</th>
                </tr>
                </thead>

                <tbody>
                <?php

                foreach ($this->Dados['logsAtendimento'] as $logsAtendimento) {
                    extract($logsAtendimento);

                    ?>

                    <tr>
                        <td><?php echo $status_log ?></td>
                        <td><?php echo date('d/m/Y', strtotime($created)) ?></td>
                        <td><?php echo date('H:i:s', strtotime($created)) ?></td>
                    </tr>

                    <?php
                }
                ?>


                </tbody>

            </table>

            <?php
            } // fim do else para exibir tabela
            //echo $this->Dados['paginacao'];

            ?>

        </div>


    </div>
</div>
