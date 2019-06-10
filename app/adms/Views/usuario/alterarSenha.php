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
    <div class="list-group-item">



        <div class="card border-0">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLADM . 'ver-perfil/perfil'; ?>">Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLADM . 'editar-perfil/alt-perfil'; ?>">Editar Perfil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Atualizar Senha</a>
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
                <form method="post" action="" class="col-md-4 pl-0">
                    <small class="text-right d-block ml-auto">
                        <span class="text-danger">* </span>Campos obrigatório
                    </small>
                    <div class="form-group">
                        <label><span class="text-danger">* </span>Senha</label>
                        <input name="senha" type="password" class="form-control" placeholder="Senha com no mínimo 6 caracteres">
                    </div>
                    <p>
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input type="submit" name="AltSenha" value="Salvar" class="btn btn-success btn-block">
                </form>
                <!-- Conteudo -->
            </div>
        </div>

    </div>
</div>
