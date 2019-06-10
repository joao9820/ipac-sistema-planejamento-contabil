<?php

if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>
<?php
//var_dump($this->Dados['dados_perfil'][0]);
if(!empty($this->Dados['dados_usuario'][0]))
{
extract($this->Dados['dados_usuario'][0]);
?>

<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Ver Usuário</h2>
            </div>
            <div class="p-2">
                <span class="d-none d-md-block">
                   <?php
                   if ($this->Dados['botao']['list_usuario']) {
                       echo "<a href='" . URLADM . "usuarios/listar' class='btn btn-outline-info btn-sm'><i class='fas fa-list'></i> Listar Usuários</a> ";
                   }
                   if ($this->Dados['botao']['edit_usuario']) {
                       echo "<a href='" . URLADM . "editar-usuario/edit-usuario/$id' class='btn btn-outline-warning btn-sm'><i class='fas fa-user-edit'></i> Editar Usuário</a> ";
                   }
                   if ($this->Dados['botao']['edit_senha']) {
                       echo "<a href='" . URLADM . "editar-senha/edit-senha/$id' class='btn btn-outline-secondary btn-sm'><i class='fas fa-lock'></i> Editar Senha</a> ";
                   }
                   if ($this->Dados['botao']['del_usuario']) {
                       echo "<a href='" . URLADM . "apagar-usuario/apagar-usuario/$id' class='btn btn-outline-danger btn-sm' data-confirm='Tem certeza de que deseja excluir o item selecionado?'><i class='fas fa-trash'></i> Apagar</a> ";
                   }
                   ?>
                </span>
                <div class="dropdown d-block d-md-none">
                    <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ações
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                        <?php
                        if ($this->Dados['botao']['list_usuario']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "usuarios/listar'>Listar</a>";
                        }
                        if ($this->Dados['botao']['edit_usuario']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "editar-usuario/edit-usuario/$id'>Editar</a>";
                        }
                        if ($this->Dados['botao']['edit_senha']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "editar-senha/edit-senha/$id'>Editar Senha</a>";
                        }
                        if ($this->Dados['botao']['del_usuario']) {
                            echo "<a class='dropdown-item' href='" . URLADM . "apagar-usuario/apagar-usuario/$id' data-confirm='Tem certeza de que deseja excluir o item selecionado?'>Apagar</a>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>


        <hr>


        <div class="row">
            <div class="col-md-3 text-center">
                <div class="card bg-light mb-3 shadow">
                    <?php
                    if (!empty($imagem))
                    {
                        echo "<img src='".URLADM."assets/imagens/usuario/".$id."/".$imagem."' class='img-fluid mx-auto' alt='".$nome."'> ";
                    } else {
                        echo "<img src='".URLADM."assets/imagens/usuario/icone_usuario.jpg' class='img-fluid mx-auto'  alt='".$nome."'> ";
                    }

                    ?>
                </div>
                <p><?php echo $nome ?></p>
            </div>
            <div class="col-md-9">
                <h5 class="font-slim">Dados pessoais</h5>
                <div id="perfilDados" class="row">
                    <div class="col-md-12 col-lg-6 col-xl-4">
                        <label for="Apelido">Apelido</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-Apelido">
                                    <i class="fas fa-user-alt"></i>
                                </span>
                            </div>
                            <input type="text" id="Apelido" class="form-control" value="<?php echo $apelido ?>" aria-describedby="basic-Apelido" disabled>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <label for="usuario">Nome de Usuário</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-usuario">
                                    <i class="fas fa-id-card-alt"></i>
                                </span>
                            </div>
                            <input type="text" id="usuario" class="form-control" value="<?php echo $usuario ?>" aria-describedby="basic-usuario" disabled>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-6 col-xl-4">
                        <label for="recuperarsenha">Recuperar Senha</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-recuperarsenha">
                                    <i class="fas fa-key"></i>
                                </span>
                            </div>
                            <input type="text" id="recuperarsenha" class="form-control" value="<?php
                                    if (!empty($recuperar_senha)) {
                                        echo URLADM . "atual-senha/atual-senha?chave=" . $recuperar_senha;
                                    }
                                    ?>" aria-describedby="basic-recuperarsenha" >
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-6">
                        <label for="email">E-mail</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-email">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="text" id="email" class="form-control" value="<?php echo $email ?>" aria-describedby="basic-email" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="nivelacesso">Papéis de Acesso</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-nivelacesso">
                                    <i class="fas fa-user-shield"></i>
                                </span>
                            </div>
                            <input type="text" id="nivelacesso" class="form-control" value="<?php echo $nome_nivel_aces ?>" aria-describedby="basic-nivelacesso" disabled>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="situacao">Situação</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-situacao">
                                    <i class="fas fa-flag"></i>
                                </span>
                            </div>
                            <input type="text" id="situacao" class="form-control text-<?php echo $cor ?>" value="<?php echo $nome_situacao?>" aria-describedby="basic-situacao" disabled>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>
</div>
    <?php
} else {
    $_SESSION['msg'] = "
    <div id='mensagemCard' class='card border-danger bg-danger d-none'>
        <div class='card-body text-light text-center' style='position: relative;'>
            <div onclick='fecharAgora()' class='text-right' style='position: absolute; top: 5px; right: 10px'>
                <i class='fas fa-times' style='cursor: pointer;'></i>
            </div>
            <i class='fas fa-times-circle fa-3x'></i>
            <h5 class='card-title'>Erro</h5>
            <p class='card-text'>Nenhum usuário encontrado!</p>
        </div>
    </div>
    ";
    $UrlDestino = URLADM .'usuarios/listar';
    header("Location: $UrlDestino");
}
?>




