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
    $valorFom = $this->Dados['form'];
}

if (isset($this->Dados['form'][0])) {
    $valorFom = $this->Dados['form'][0];
}

?>
<div class="content p-1">
    <div class="list-group-item">
        <div class="d-flex">
            <div class="mr-auto p-2">
                <h2 class="display-4 titulo">Editar Usuário</h2>
            </div>
            <?php
            if ($this->Dados['botao']['vis_usuario']) {
            ?>
            <div class="p-2">
                <span class="d-block">
                    <a href="<?php echo URLADM . 'ver-usuario/ver-usuario/'.$valorFom['id']; ?>" class="btn btn-outline-primary btn-sm"><i class="far fa-eye"></i> Visualizar</a>
                </span>
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

        <form method="post" action="" enctype="multipart/form-data">
            <input name="id" type="hidden" value="<?php if (isset($valorFom['id'])) { echo $valorFom['id']; } ?>">


            <div class="row">
                <div class="col-md-3">
                    <div class="form-row">
                        <label class="">Foto de Perfil</label>
                        <div class="form-group col-md-12">
                            <div class="d-flex">
                                <input type="file" name="imagem_nova" id="arquivo" class="arquivo" onchange="previewImagemUsuario();">
                                <input type="button" class="btnImg" value="Selecionar">
                                <input type="text" id="file" class="file form-control" placeholder="Arquivo" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group col-md-12 mx-0">
                            <?php
                            if (isset($valorFom['imagem']) AND !empty($valorFom['imagem'])) {
                                $imagem_antiga = URLADM . 'assets/imagens/usuario/' . $valorFom['id'] . '/' . $valorFom['imagem'];
                            }
                            elseif (isset($valorFom['imagem_antiga']) AND !empty($valorFom['imagem_antiga'])) {
                                $imagem_antiga = URLADM . 'assets/imagens/usuario/' . $valorFom['id'] . '/' . $valorFom['imagem_antiga'];
                            }
                            else {

                                $imagem_antiga = URLADM . 'assets/imagens/usuario/icone_usuario.jpg';
                            }
                            ?>
                            <img src="<?php echo $imagem_antiga; ?>" class="img-thumbnail imgPerfil" alt="Imagem do Usuário" id="preview-user"  >
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">* </span>Nome</label>
                            <input name="nome" type="text" class="form-control" placeholder="Digite o nome completo"
                                   value="<?php if (isset($valorFom['nome'])) { echo $valorFom['nome']; } ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label><span class="text-danger">* </span>E-mail</label>
                            <input name="email" type="email" class="form-control" placeholder="Seu e-mail"
                                   value="<?php if (isset($valorFom['nome'])) { echo $valorFom['email']; } ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">* </span>Usuário</label>
                            <input name="usuario" type="text" class="form-control" placeholder="Nome para acesso ao sistema"
                                   value="<?php if (isset($valorFom['nome'])) { echo $valorFom['usuario']; } ?>">
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">* </span>Situação</label>
                            <select name="adms_sits_usuario_id" id="situacao" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['sit'] as $sit) {
                                    extract($sit);
                                    if ( $valorFom['adms_sits_usuario_id'] == $id_sit )
                                    {
                                        echo "<option value='$id_sit' selected>$nome_sit</option>";
                                    } else {
                                        echo "<option value='$id_sit'>$nome_sit</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label><span class="text-danger">* </span>Nível de Acesso</label>
                            <select name="adms_niveis_acesso_id" id="nivel-acesso" class="form-control">
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->Dados['select']['nivac'] as $nivac) {
                                    extract($nivac);
                                    if ($valorFom['adms_niveis_acesso_id'] == $id_nivac)
                                    {
                                        echo "<option value='$id_nivac' selected>$nome_nivac</option>";
                                    } else {
                                        echo "<option value='$id_nivac'>$nome_nivac</option>";
                                    }

                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <p class=" mt-4">
                        <span class="text-danger">* </span>Campo obrigatório
                    </p>
                    <input type="submit" name="EditUsuario" value="Salvar" class="btn btn-outline-success">

                </div>
            </div>



        </form>
    </div>
</div>
