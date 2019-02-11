<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
if (!empty($this->Dados['dados_usuario'][0])) {
    extract($this->Dados['dados_usuario'][0]);
    ?>
    <dl class="row">
        <dt class="col-sm-3">Foto</dt>
        <dd class="col-sm-9">
            <?php
            if (!empty($imagem))
            {
                echo "<img src='".URLADM."assets/imagens/usuario/".$id."/".$imagem."' class='img-fluid'  width='150' height='150'  alt='".$nome."'> ";
            } else {
                echo "<img src='".URLADM."assets/imagens/usuario/icone_usuario.jpg' class='img-fluid'  width='150' height='150'  alt='".$nome."'> ";
            }
            ?>
        </dd>

        <dt class="col-sm-3">ID</dt>
        <dd class="col-sm-9"><?php echo $id; ?></dd>

        <dt class="col-sm-3">Nome</dt>
        <dd class="col-sm-9"><?php echo $nome; ?></dd>

        <dt class="col-sm-3">Apelido</dt>
        <dd class="col-sm-9"><?php echo $apelido; ?></dd>

        <dt class="col-sm-3">E-mail</dt>
        <dd class="col-sm-9"><?php echo $email; ?></dd>

        <dt class="col-sm-3">Usuário</dt>
        <dd class="col-sm-9"><?php echo $usuario; ?></dd>

        <dt class="col-sm-3">Recuperar Senha</dt>
        <dd class="col-sm-9"><?php
            if (!empty($recuperar_senha)) {
                echo URLADM . "atual-senha/atual-senha?chave=" . $recuperar_senha;
            }
            ?></dd>

        <dt class="col-sm-3">Nível de Acesso</dt>
        <dd class="col-sm-9"><?php echo $nome_nivel_aces; ?></dd>

        <dt class="col-sm-3">Situação</dt>
        <dd class="col-sm-9">
            <span class="badge badge-<?php echo $cor; ?>"><?php echo $nome_situacao; ?></span>
        </dd>

        <dt class="col-sm-3">Inserido</dt>
        <dd class="col-sm-9"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></dd>

        <dt class="col-sm-3">Alterado</dt>
        <dd class="col-sm-9"><?php
            if (!empty($modified)) {
                echo date('d/m/Y H:i:s', strtotime($modified));
            }
            ?>
        </dd>
    </dl>
    <?php
} else {
    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não encontrado!</div>";
    $UrlDestino = URLADM . 'carregar-usuarios-js/listar';
    header("Location: $UrlDestino");
}
