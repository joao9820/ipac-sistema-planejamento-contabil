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
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Alterar Senha</h2>
            </div>
            <div class="p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'ver-perfil/perfil'; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                </span>
            </div>
        </div><hr>

        <?php
            if(isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
        ?>

        <form method="post" action="">

            <div class="form-group">
                <label><span class="text-danger">* </span>Senha</label>
                <input name="senha" type="password" class="form-control" placeholder="Senha com mínimo 6 caracteres">
            </div>
            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="AltSenha" value="Salvar" class="btn btn-warning">
        </form>
    </div>
</div>
