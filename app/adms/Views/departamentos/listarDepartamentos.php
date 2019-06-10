<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 25/03/2019
 * Time: 12:19
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex flex-column flex-md-row">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Departamentos</h2>
            </div>
            <div class="d-flex justify-content-end p-2">
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
        <span>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success btn-sm my-2" data-toggle="modal" data-target="#cadastrarDepartamento">
              Cadastrar Departamento
            </button>
        </span>
        <div class="table-responsive">
            <table class="table table-striped table-hover border">
                <thead class="bg-info text-light">
                    <tr>
                        <th scope="col" class="">Departamento</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                foreach ($this->Dados['listarDepartamentos'] as $funcionario)
                {
                    extract($funcionario);
                    ?>
                    <tr>
                        <td scope="row"><?php echo $nome; ?></td>
                        <?php
                        if (!$this->Dados['botao']['editar_dept']) {
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
<!-- Modal -->
<div class="modal fade" id="cadastrarDepartamento" tabindex="-1" role="dialog" aria-labelledby="cadastrarDepartamentoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="<?php echo URLADM . 'departamentos/store' ?>" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="cadastrarDepartamentoLabel">Novo departamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nomeDepart">Departamento</label>
                        <input type="text" name="nome" class="form-control" id="nomeDepart" placeholder="Nome" required>
                    </div>
                    <div class="form-group">
                        <label for="gerente_id">Gerente</label>
                        <select name="gerente_id" class="form-control" id="gerente_id" required>
                            <option>Selecione um gerente</option>
                            <?php
                                foreach ($this->Dados['listaDeGerentes'] as $gerente){
                                    echo "<option value='{$gerente['id']}'>{$gerente['nome']}</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

