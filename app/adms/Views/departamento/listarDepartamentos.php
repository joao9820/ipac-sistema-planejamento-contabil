<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/03/2019
 * Time: 12:19
 */

?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Departamentos</h2>
            </div>
            <div class="d-flex p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'jornada-de-trabalho/listar'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar Funcionários</a>
                </span>
            </div>
        </div>
        <?php
        if (empty($this->Dados['listarDepartamentos'])) {
            ?>
            <div class="alert alert-secondary text-center alert-dismissible fade show" role="alert">
                <i class="fas fa-user-tie fa-6x my-3 text-secondary"></i>
                <h5 class="text-secondary">Nenhum departamento encontrado!</h5>
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
                        <th scope="col" class="icon">#</th>
                        <th scope="col" class="">Departamento</th>
                        <th scope="col" class="d-none d-lg-table-cell">Descrição</th>
                        <?php
                        if ($this->Dados['botao']['editar_dept']) {
                            ?>
                            <th scope="col" class="text-center">Ações</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($this->Dados['listarDepartamentos'] as $funcionario)
                {
                    extract($funcionario);
                    ?>
                    <tr>
                        <td scope="row"><i class="<?php echo $icon; ?>"></i></td>
                        <td scope="row"><?php echo $nome; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $descricao; ?></td>
                        <?php
                        if ($this->Dados['botao']['editar_dept']) {
                            ?>
                            <td class="text-center">
                            <span class="d-none d-md-block">
                                <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true"
                                      title="Editar">
                                <?php
                                if ($this->Dados['botao']['editar_dept']) {
                                    ?>
                                    <a href="<?php echo URLADM . 'editar-departamento/editar/' . $id; ?>"
                                       class="btn btn-outline-secondary btn-sm my-md-1"
                                       data-confirmEditFunc='EditarFuncionario'><i class="fas fa-edit"></i></a>
                                    <?php
                                }
                                ?>
                                </span>
                            </span>
                                <div class="dropdown d-block d-md-none">
                                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                                            id="acoesListar"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Ações
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                        <?php
                                        if ($this->Dados['botao']['editar_dept']) {
                                            ?>
                                            <a class="dropdown-item"
                                               href="<?php echo URLADM . 'editar-departamento/editar/' . $id; ?>"
                                               data-confirmEditFunc='EditarFuncionario'><i class="fas fa-edit"></i></a>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </td>
                            <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <?php
            } // Fim do else para verificar se tem dados para exibir
            ?>
        </div>
    </div>
</div>

