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
//var_dump($this->Dados['botao'])
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Listar Demandas</h2>
            </div>

            <?php
                if ($this->Dados['botao']['cad_demanda']) {
                    ?>
                    <a href="<?php echo URLADM . 'cadastrar-demanda/cad-demanda'; ?>">
                        <div class="p-2">
                            <button class="btn btn-success btn-sm">
                                Cadastrar
                            </button>
                        </div>
                    </a>
                    <?php
                }
            ?>

        </div>

        <?php
            if (empty($this->Dados['listDemanda'])) {
                ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Nenhuma demanda encontrada!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php
            }
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>



        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                <tr>
                    <th class="">Demanda</th>
                    <th class="d-none d-lg-table-cell">Descrição</th>
                    <th class="text-center">Ações</th>
                </tr>
                </thead>

                <tbody>
                <?php

                    foreach ($this->Dados['listDemanda'] as $demanda) {
                        extract($demanda);

                        ?>

                        <tr>
                            <td><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $descricao; ?></td>
                            <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <?php
                                                if ($this->Dados['botao']['vis_demanda']) { ?>
                                                    <a href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id; ?>" class="btn btn-info btn-sm my-md-1">Visualizar</a>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if ($this->Dados['botao']['edit_demanda']) { ?>
                                                    <a href="<?php echo URLADM . 'editar-demanda/edit-demanda/'.$id; ?>" class="btn btn-warning btn-sm my-md-1">Editar</a>
                                                    <?php
                                                }
                                            ?>
                                            <?php
                                                if ($this->Dados['botao']['del_demanda']) { ?>
                                                    <a href="<?php echo URLADM . 'apagar-demanda/apagar-demanda/'.$id; ?>" class="btn btn-danger btn-sm my-md-1"
                                                data-confirmDema='Tem certeza que deseja excluir a demanda selecionada e todas as atividades nela cadastrada?'>Apagar</a>
                                                    <?php
                                                }
                                            ?>
                                        </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php if ($this->Dados['botao']['vis_demanda']) { ?>
                                            <a class="dropdown-item" href="<?php echo URLADM . 'ver-demanda/ver-demanda/' . $id; ?>">Visualizar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botao']['edit_demanda']) { ?>
                                            <a class="dropdown-item" href="<?php echo URLADM . 'editar-demanda/edit-demanda/'.$id; ?>">Editar</a>
                                        <?php } ?>
                                        <?php if ($this->Dados['botao']['del_demanda']) { ?>
                                            <a class="dropdown-item" href="<?php echo URLADM . 'apagar-demanda/apagar-demanda/'.$id; ?>"
                                               data-confirmDema='Tem certeza que deseja excluir a demanda selecionada e todas as atividades nela cadastrada?'>Apagar</a>
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

                echo $this->Dados['paginacao'];

            ?>

        </div>
    </div>
</div>
