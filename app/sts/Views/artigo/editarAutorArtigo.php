<?php
if (isset($this->Dados['form'])) {
    $valorForm = $this->Dados['form'];
}
if (isset($this->Dados['form'][0])) {
    $valorForm = $this->Dados['form'][0];
}
//var_dump($this->Dados['select']);
?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Artigo</h2>
            </div>

            <?php
            if ($this->Dados['botao']['vis_art']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'ver-artigo/ver-artigo/' . $valorForm['id']; ?>" class="btn btn-outline-primary btn-sm">Visualizar</a>
                </div>
                <?php
            }
            ?>

        </div><hr>
        <?php
        if (isset($_SESSION['msg'])) {
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
        }
        ?>
        <form method="POST" action="" enctype="multipart/form-data"> 
            <input name="id" type="hidden" value="<?php
            if (isset($valorForm['id'])) {
                echo $valorForm['id'];
            }
            ?>">

            <div class="form-row">
                    <div class="form-group col-md-12">
                        <label><span class="text-danger">*</span> Autor do Artigo</label>
                        <select name="adms_usuario_id" id="adms_usuario_id" class="form-control">
                            <option value="">Selecione</option>
                            <?php
                            $cont = 1;
                            foreach ($this->Dados['select']['user'] as $user) {
                                extract($user);
                                if ($valorForm['adms_usuario_id'] == $id_user) {
                                    echo "<option value='$id_user' selected>$nome_user</option>";
                                    $cont = 2;
                                } elseif (($_SESSION['usuario_id'] == $id_user) AND ( $cont == 1)) {
                                    echo "<option value='$id_user' selected>$nome_user</option>";
                                } else {
                                    echo "<option value='$id_user'>$nome_user</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input name="EditAutorArtigo" type="submit" class="btn btn-warning" value="Salvar">
        </form>
    </div>
</div>