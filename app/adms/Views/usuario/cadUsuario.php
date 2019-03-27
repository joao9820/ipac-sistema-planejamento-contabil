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
                <h2 class="display-4 titulo">Cadastrar Usuário</h2>
            </div>
            <?php
            if ($this->Dados['botao']['list_usuario']) {
                ?>
                <div class="p-2">
                    <a href="<?php echo URLADM . 'usuarios/listar'; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-list"></i> Listar Usuários</a>
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

            <div class="form-row">
                <div class="form-group col-md-8">
                    <label><span class="text-danger">* </span>Nome</label>
                    <input name="nome" type="text" class="form-control" placeholder="Digite o nome completo"
                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['nome']; } ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Apelido</label>
                    <input name="apelido" type="text" class="form-control" placeholder="Como gostaria de ser chamado"
                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['apelido']; } ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-5">
                    <label><span class="text-danger">* </span>E-mail</label>
                    <input name="email" type="email" class="form-control" placeholder="Seu e-mail"
                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['email']; } ?>">
                </div>
                <div class="form-group col-md-4">
                    <label><span class="text-danger">* </span>Usuário</label>
                    <input name="usuario" type="text" class="form-control" placeholder="Digite o usuário"
                           value="<?php if (isset($valorFom['nome'])) { echo $valorFom['usuario']; } ?>">
                </div>
                <div class="form-group col-md-3">
                    <label><span class="text-danger">* </span>Senha</label>
                    <input name="senha" type="password" class="form-control" placeholder="Digite senha no mínimo 6 caracteres"
                           value="<?php if (isset($valorFom['senha'])) { echo $valorFom['senha']; } ?>">
                </div>
            </div>


            <div class="form-row">

                <div class="form-group col-md-6">
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

                <div class="form-group col-md-6">
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

            </div>


            <div class="form-row">

                <div class="form-group col-md-3">
                    <label>Foto ( 150x150 )</label>

                    <div class="d-flex">
                        <input type="file" name="imagem_nova" id="arquivo" class="arquivo" onchange="previewImagemUsuario();">
                        <input type="button" class="btnImg" value="Selecionar">
                        <input type="text" id="file" class="file form-control" placeholder="Arquivo" readonly="readonly">

                    </div>

                </div>
                <div class="form-group col-md-6">
                    <?php
                        $imagem_antiga = URLADM . 'assets/imagens/usuario/icone_cad_usuario.jpg';
                    ?>
                    <img src="<?php echo $imagem_antiga; ?>" class="img-thumbnail" alt="Imagem do Usuário" id="preview-user" style="width: 150px; height: 150px" >
                </div>
            </div>


            <p>
                <span class="text-danger">* </span>Campo obrigatório
            </p>
            <input type="submit" name="CadUsuario" value="Cadastrar" class="btn btn-outline-success">
        </form>
    </div>
</div>
