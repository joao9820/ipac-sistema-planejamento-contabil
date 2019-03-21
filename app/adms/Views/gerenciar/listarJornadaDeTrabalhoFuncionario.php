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
//var_dump($this->Dados['listFuncionarios'])
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Gerenciar Funcinários</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_usuario']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-usuario/cad-usuario'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-user-plus"></i> Cadastrar Funcionário
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>
        </div>

        <?php
            if (empty($this->Dados['listFuncionarios'])) {
                ?>

                <div class="alert alert-secondary text-center alert-dismissible fade show" role="alert">
                    <i class="fas fa-user-tie fa-6x my-3 text-secondary"></i>
                    <h5 class="text-secondary">Nenhum funcionário encontrado!</h5>
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


        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead class="bg-info text-light">
                <tr>
                    <th scope="col" class="">Nome</th>
                    <th scope="col" class="d-none d-lg-table-cell">Departamento</th>
                    <th scope="col" class="d-none d-lg-table-cell">Cargo</th>
                    <th scope="col" class="d-none d-lg-table-cell">Jornada de Trabalho</th>
                    <th scope="col" class="text-center">Ações</th>
                </tr>
                </thead>

                <tbody>
                <?php

                foreach ($this->Dados['listFuncionarios'] as $funcionario) {
                    extract($funcionario);

                    ?>

                    <tr>
                        <td scope="row"><?php echo $nome; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $departamento; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $cargo; ?></td>
                        <td class="d-none d-sm-table-cell"><?php
                            if (!empty($jornada_de_trabalho)) {
                                echo date('H:i', strtotime($jornada_de_trabalho));
                            }
                            ?>
                        </td>
                        <td class="text-center">
                                        <span class="d-none d-md-block">
                                            <?php
                                            if ($this->Dados['botao']['editar_jornada']) { ?>
                                                <a href="<?php echo URLADM . 'editar-jornada-de-trabalho/editar/' . $id; ?>"
                                                   class="btn btn-outline-secondary btn-sm my-md-1"
                                                   data-confirmEditFunc='EditarFuncionario'><i class="fas fa-edit"></i> Editar</a>
                                                <?php
                                            }
                                            ?>
                                        </span>
                            <div class="dropdown d-block d-md-none">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                    <?php if ($this->Dados['botao']['editar_jornada']) { ?>
                                        <a class="dropdown-item"
                                           href="<?php echo URLADM . 'editar-jornada-de-trabalho/editar/' . $id; ?>"
                                           data-confirmEditFunc='EditarFuncionario'><i class="fas fa-edit"></i> Editar</a>
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

            //echo $this->Dados['paginacao'];
            } // Fim do else para verificar se tem dados para exibir
            ?>

        </div>
    </div>
</div>
