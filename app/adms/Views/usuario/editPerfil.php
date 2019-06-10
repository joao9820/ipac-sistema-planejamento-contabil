<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:12
 */
if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>
<div class="content p-1">
    <div class="list-group-item pt-0 pl-0 pr-0">

        <div class="card border-0 shadow-none">
            <div class="card-header bg-powercar">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLADM . 'ver-perfil/perfil'; ?>">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Editar Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLADM . 'alterar-senha/alt-senha'; ?>">Atualizar Senha</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <?php
                if(isset($_SESSION['msg'])) {
                    echo $_SESSION['msg'];
                    unset($_SESSION['msg']);
                }

                if (isset($this->Dados['form'])) {
                    $valorFom = $this->Dados['form'];
                }

                if (isset($this->Dados['form'][0])) {
                    $valorFom = $this->Dados['form'][0];
                }
                ?>
                <!-- Conteudo -->
                <form method="post" action="" enctype="multipart/form-data">

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-row">
                                <label class="">Foto de Perfil</label>
                                <div class="form-group col-md-12">
                                    <input type="hidden" name="imagem_antiga" value="<?php
                                    if (isset($valorFom['imagem_antiga'])) {
                                        echo $valorFom['imagem_antiga'];
                                    } elseif (isset($valorFom['imagem'])) {
                                        echo $valorFom['imagem'];
                                    }
                                    ?>">
                                    <div class="d-flex">
                                        <input type="file" name="imagem" id="arquivo" class="arquivo" onchange="previewImagem();">
                                        <input type="button" class="btnImg" value="Selecionar">
                                        <input type="text" id="file" class="file form-control" placeholder="imagem..." readonly="readonly">
                                    </div>
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <?php
                                    if (isset($valorFom['imagem']) AND !empty($valorFom['imagem'])) {
                                        $imagem_antiga = URLADM . 'assets/imagens/usuario/' . $_SESSION['usuario_id'] . '/' . $_SESSION['usuario_imagem'];
                                    } else {

                                        $imagem_antiga = URLADM . 'assets/imagens/usuario/icone_usuario.jpg';
                                    }
                                    ?>
                                    <img src="<?php echo $imagem_antiga; ?>" class="img-thumbnail  imgPerfil" alt="Imagem do Usuário" id="preview-user" >
                                </div>


                            </div>

                        </div>
                        <div class="col-md-5">
                            <small class="text-right d-block ml-auto">
                                <span class="text-danger">* </span>Campos obrigatório
                            </small>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label><span class="text-danger">* </span>Nome</label>
                                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome completo"
                                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['nome']; } ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label><span class="text-danger">* </span>Usuário</label>
                                    <input name="usuario" type="text" class="form-control" placeholder="Digite o usuário"
                                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['usuario']; } ?>">
                                </div>
                                <div class="form-group col-md-12">
                                    <label><span class="text-danger">* </span>E-mail</label>
                                    <input name="email" type="email" class="form-control" placeholder="Seu e-mail"
                                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['email']; } ?>">
                                </div>
                            </div>
                            <div class="text-left">
                                <input type="submit" name="EditPerfil" value="Salvar" class="btn btn-success btn-block">
                            </div>
                        </div>
                    </div>

                </form>
                <!-- Conteudo -->
            </div>
        </div>

    </div>
</div>
