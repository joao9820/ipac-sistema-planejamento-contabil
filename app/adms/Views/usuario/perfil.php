<?php

if (!defined('URL')) {
    header("Location: /");
    exit();
}

?>
<div class="content p-1">
    <div class="list-group-item">

        <div class="card border-0">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLADM . 'editar-perfil/alt-perfil'; ?>">Editar Perfil</a>
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
                ?>
                <!-- Conteudo -->
                <div class="row">

                    <?php
                    //var_dump($this->Dados['dados_perfil'][0]);
                    if(!empty($this->Dados['dados_perfil'][0]))
                    {
                        extract($this->Dados['dados_perfil'][0]);
                        ?>
                        <div class="col-md-2">
                            <?php
                            if (!empty($_SESSION['usuario_imagem']))
                            {
                                echo "<img src='".URLADM."assets/imagens/usuario/".$_SESSION['usuario_id']."/".$_SESSION['usuario_imagem']."' class='img-fluid'    alt='".$_SESSION['usuario_imagem']."'> ";
                            } else {
                                echo "<img src='".URLADM."assets/imagens/usuario/icone_usuario.jpg' class='img-fluid'  width='150' height='150'  alt='".$_SESSION['usuario_imagem']."'> ";
                            }
                            ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group row">
                                <label for="nome" class="col-md-3 pb-0 col-form-label"><strong>Nome: </strong></label>
                                <div class="col-md-12">
                                    <input type="text" readonly class="form-control-plaintext pt-0" id="nome" value="<?php echo $nome ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="usuario" class="col-md-3 pb-0 col-form-label"><strong>Usuário: </strong></label>
                                <div class="col-md-12">
                                    <input type="text" readonly class="form-control-plaintext pt-0" id="usuario" value="<?php echo $usuario ?>" disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-sm-3 pb-0 col-form-label"><strong>E-mail: </strong></label>
                                <div class="col-md-12">
                                    <input type="text" readonly class="form-control-plaintext pt-0" id="email" value="<?php echo $email ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <!-- Conteudo -->
            </div>
        </div>
    </div>
</div>
