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
                <h2 class="display-4 titulo">Listar Nível de Acesso</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                    <?php
                    if ($this->Dados['botao']['sincro_permi']) {
                        echo "<a href='" . URLADM . "sincro-pg-niv-ac/sincro-pg-niv-ac' class='btn btn-outline-dark btn-sm'><i class='fas fa-sync-alt'></i> Sincronizar</a> ";
                    }
                    if ($this->Dados['botao']['cad_nivac']) {
                        echo "<a href='" . URLADM . "cadastrar-niv-ac/cad-niv-ac' class='btn btn-outline-success btn-sm'><i class='fas fa-plus'></i> Cadastrar</a> ";
                    }
                    ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->Dados['botao']['sincro_permi']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "sincro-pg-niv-ac/sincro-pg-niv-ac'>Sincronizar</a>";
                        }
                        if ($this->Dados['botao']['cad_nivac']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "cadastrar-niv-ac/cad-niv-ac'>Cadastrar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <?php
        if (empty($this->Dados['listNivAc'])) {
            ?>
            <div class="alert alert-danger" role="alert">
                Nenhum nível de acesso encontrado!
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
                        <th class="d-none d-sm-table-cell">Ordem</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qnt_linhas_exe = 1;
                    foreach ($this->Dados['listNivAc'] as $nivAc) {
                        extract($nivAc);
                        ?>
                        <tr>
                            <th><?php echo $id; ?></th>
                            <td><?php echo $nome; ?></td>
                            <td class="d-none d-sm-table-cell"><?php echo $ordem; ?></td>
                            <td class="text-right">
                                <span class="d-none d-md-block">
                                    <?php
                                    if ($qnt_linhas_exe <= 2) {
                                        if ($this->Dados['botao']['ordem_nivac']) {
                                            echo "<button class='btn btn-outline-secondary btn-sm disabled'><i class='fas fa-angle-double-up'></i></button> ";
                                        }
                                    } else {
                                        if ($this->Dados['botao']['ordem_nivac']) {
                                            echo "<a href='" . URLADM . "alt-ordem-niv-ac/alt-ordem-niv-ac/$id' class='btn btn-outline-secondary btn-sm'><i class='fas fa-angle-double-up'></i></a> ";
                                        }
                                    }
                                    $qnt_linhas_exe++;
                                    if ($this->Dados['botao']['list_permi']) {
                                        ?>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Permissões"> 
                                            <a href= "<?php echo URLADM . 'permissoes/listar/1?niv='.$id ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-unlock-alt"></i></a>
                                        </span>
                                        <?php
                                    }
                                    if ($this->Dados['botao']['vis_nivac']) {
                                        ?>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Visualizar"> 
                                            <a href=" <?php echo URLADM . 'ver-niv-ac/ver-niv-ac/'.$id ?>" class="btn btn-outline-primary btn-sm"><i class='far fa-eye'></i></a> 
                                        </span>
                                        <?php
                                    }
                                    if ($this->Dados['botao']['edit_nivac']) {
                                        ?>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Editar"> 
                                            <a href=" <?php echo URLADM . 'editar-niv-ac/edit-niv-ac/'.$id ?>" class="btn btn-outline-warning btn-sm"><i class='fas fa-edit'></i></a>
                                        </span>
                                        <?php
                                    }
                                    if ($this->Dados['botao']['del_nivac']) {
                                        ?>
                                        <span tabindex="0" data-toggle="tooltip" data-placement="left" data-html="true" title="Apagar"> 
                                         <a href=" <?php echo URLADM . 'apagar-niv-ac/apagar-niv-ac/'.$id ?>" class="btn btn-outline-danger btn-sm" data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-trash'></i></a>
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
                                        if ($this->Dados['botao']['vis_nivac']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "ver-niv-ac/ver-niv-ac/$id'>Visualizar</a>";
                                        }
                                        if ($this->Dados['botao']['edit_nivac']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "editar-niv-ac/edit-niv-ac/$id'>Editar</a>";
                                        }
                                        if ($this->Dados['botao']['del_nivac']) {
                                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-niv-ac/apagar-niv-ac/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
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
