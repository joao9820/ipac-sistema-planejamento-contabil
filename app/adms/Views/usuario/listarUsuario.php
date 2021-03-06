<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Usuários</h2>
            </div>
            <?php
            if ($this->Dados['botao']['cad_usuario']) {
                ?>
                <a href="<?php echo URLADM . 'cadastrar-usuario/cad-usuario'; ?>">
                    <div class="p-2">
                        <button class="btn btn-outline-success btn-sm">
                            <i class="fas fa-user-plus"></i> Cadastrar
                        </button>
                    </div>
                </a>
                <?php
            }
            ?>

        </div>
        <?php
        if (empty($this->Dados['listUser'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum usuário encontrado!
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
            <table class="table table-striped table-hover table-border">
                <thead class="bg-info text-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th class="d-none d-lg-table-cell">E-mail</th>
                    <th class="d-none d-lg-table-cell">Situação</th>
                    <th class="text-right">Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($this->Dados['listUser'] as $usuario) {
                    extract($usuario);
                    ?>
                    <tr>
                        <th><?php echo $id; ?></th>
                        <td><?php echo $nome; ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo $email; ?></td>
                        <td class="d-none d-lg-table-cell">
                            <span class="badge badge-<?php echo $cor_cr; ?>"><?php echo $nome_sit; ?></span>
                        </td>
                        <td class="text-right">
                            <span class="d-none d-md-block">
                                <?php
                                if ($this->Dados['botao']['vis_usuario']) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Visualzar">
                                        <a href=" <?php echo URLADM . 'ver-usuario/ver-usuario/'.$id ?>" class="btn btn-outline-primary btn-sm my-md"><i class="far fa-eye"></i></a>
                                    </span>
                                    <?php
                                }

                                if ($this->Dados['botao']['edit_usuario']) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar">
                                        <a href="<?php echo URLADM . 'editar-usuario/edit-usuario/'. $id ?>" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i></a>
                                    </span>
                                    <?php
                                }

                                if ($this->Dados['botao']['del_usuario']) { ?>
                                    <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Apagar">
                                        <a href="<?php echo URLADM . 'apagar-usuario/apagar-usuario/'.$id ?>" class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-trash'></i></a>
                                    </span>
                                    <?php
                                }
                                ?>
                            </span>
                            
                            <div class="dropdown d-block d-md-none">
                                <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Ações
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                    <?php
                                    if ($this->Dados['botao']['vis_usuario']) {
                                        echo "<a class='dropdown-item' href='". URLADM . "ver-usuario/ver-usuario/$id'>Visualizar</a>";
                                    }
                                    if ($this->Dados['botao']['edit_usuario']) {
                                        echo "<a class='dropdown-item' href='". URLADM . "editar-usuario/edit-usuario/$id'>Editar</a>";
                                    }
                                    if ($this->Dados['botao']['del_usuario']) {
                                        echo "<a class='dropdown-item' href='". URLADM . "apagar-usuario/apagar-usuario/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                                    }
                                    ?>


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
