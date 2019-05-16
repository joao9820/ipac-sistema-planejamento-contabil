<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<style>
    .border {
        border: 2px solid #FFF !important;
    }
</style>
<!-- DIV FLEX CONTEUDO -->
<div class="d-flex">
    <nav class="sidebar">
        <ul class="list-unstyled">
            <li>
                <a class="d-flex flex-column" href="<?php echo URLADM . "ver-perfil/perfil"; ?>">
                    <div class="text-light">
                        <?php if(isset($_SESSION['usuario_imagem']) AND (!empty($_SESSION['usuario_imagem']))) { ?>
                            <img class=" imgPerfil rounded-circle border-light border" src="<?php echo URLADM . 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/'. $_SESSION['usuario_imagem'] ?>" width="60" height="60">
                        <?php } else { ?>
                            <img class="rounded-circle border-light border" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.jpg'?>" width="60" height="60">
                        <?php } ?>
                        <span class="text-center"><?php echo $_SESSION['usuario_nome']; ?></span>
                    </div>
                    <small class="text-secondary my-3">
                        <?php
                        if ($_SESSION['nome_nivel']) {
                            echo $_SESSION['nome_nivel'];
                        }
                        ?>
                    </small>
                </a>
            </li>

        </ul>
        <ul class="list-unstyled">

            <?php
            $cont_drop = 0;
            $cont_drop_fech = 0;
            foreach ($this->Dados['menu'] as $menu) {
                extract($menu);
                if ($dropdown == 1)
                {

                    // MENU DROPDOWN
                    if($cont_drop != $id_men)
                    {
                        if(($cont_drop_fech == 1) AND ($cont_drop != 0))
                        {
                            // Fechamento do dropdown
                            echo "</ul>";
                            echo "</li>";

                            $cont_drop_fech = 0;
                        }
                        // Abertura do dropdown
                        echo "<li>";
                        echo "<a href='#submenu".$id_men."' data-toggle='collapse'>";
                        echo "<i class='".$icone_men."'></i> ".$nome_men;
                        echo "</a>";
                        echo "<ul id='submenu".$id_men."' class='list-unstyled collapse'>";
                        $cont_drop = $id_men;
                    }

                    echo "<li><a href='" . URLADM .$menu_controller."/".$menu_metodo."'><i class='".$icone_pg."'></i> ".$nome_pagina." </a></li>";
                    //echo "<li><a href='#'><i class='fas fa-key'></i> Nível de Acesso</a></li>";

                    $cont_drop_fech = 1;

                } else {

                    if(($cont_drop_fech == 1))
                    {
                        // Fechamento do dropdown
                        echo "</ul>";
                        echo "</li>";
                        $cont_drop_fech = 0;
                    }

                    echo "<li><a href='" . URLADM .$menu_controller."/".$menu_metodo."'><i class='".$icone_men."'></i> ".$nome_men."</a></li>";

                }
            }
            if(($cont_drop_fech == 1))
            {
                // Fechamento do dropdown
                echo "</ul>";
                $cont_drop_fech = 0;
            }
            ?>

        </ul>
    </nav>