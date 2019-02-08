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

//var_dump($this->Dados['select']);
//var_dump($this->Dados['form'][0]);

if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}

if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Cadastrar Demanda</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_demanda']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'demandas/listar'; ?>" class="btn btn-info btn-sm">Listar</a>
                </div>
                <?php
            }
            ?>
        </div><hr>

        <?php
        if(isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        ?>

        <form method="post" action="" class="col-md-6">

            <div class="form-row">
                <div class="form-group col-md-10">
                    <label><span class="text-danger">* </span>Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome da demanda"
                           value="<?php if (isset($valorForm['nome'])) { echo $valorForm['nome']; } ?>">
                </div>
                <div class="form-group col-md-10">
                    <label><span class="text-danger">* </span>Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?php if(isset($valorForm['descricao'])) {echo $valorForm['descricao'];}?></textarea>

                </div>
            </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="CadDemanda" value="Cadastrar" class="btn btn-warning">
        </form>
    </div>
</div>
