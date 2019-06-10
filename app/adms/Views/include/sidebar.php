<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>

<!-- Conteudo Principal -->
<div id="main" class="row container-fluid pr-0">
    <section id="menuLateral" class="d-mobile-none">
        <div class="container-fluid px-0">
            <!-- Perfil -->
            <a  href="<?php echo URLADM . 'ver-perfil/perfil' ?>" class="perfil-menu my-4">
                <div>
                    <figure class="text-center">
                        <?php if(isset($_SESSION['usuario_imagem']) AND (!empty($_SESSION['usuario_imagem']))) { ?>
                            <img class="img-fluid img-menu-mobile" src="<?php echo URLADM . 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/'. $_SESSION['usuario_imagem'] ?>" width="20" height="20">
                        <?php } else { ?>
                                <img class="img-fluid img-menu-mobile" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.jpg'?>" width="20" height="20">
                        <?php } ?>
                    </figure>
                </div>
                <div class="d-flex flex-column text-center">
                    <span class="small">Bem vindo(a)</span>
                    <small class="">
                        <?php
                            $nome = explode(" ", $_SESSION['usuario_nome']);
                            $prim_nome = $nome[0];
                            echo $prim_nome; 
                        ?>
                    </small>
                    <span id="tipoPerfilDesktop" class="mt-2">
                        <small><i class="fas fa-id-badge"></i>  
                            <?php
                                if ($_SESSION['nome_nivel']) {
                                    echo $_SESSION['nome_nivel'];
                                }
                            ?>
                        </small>
                    </span>
                </div>
            </a><!-- Fim Perfil-->

            <nav id="navBarLateral" class="nav flex-column">

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
                                if ($nome_men != "Configuração"){
                                // Fechamento do dropdown
                                echo "</div>";
                                echo "</div>";

                                $cont_drop_fech = 0;
                                }
                            }
                            // se o dropdown for diferente de configuração
                            if ($nome_men != "Configuração"){
                            ?>
                            <a class="nav-link py-2" href="#" data-toggle="collapse" data-target="#collapse<?php echo $id_men ?>" aria-expanded="false" aria-controls="collapseOne<?php echo $id_men ?>">
                                <i class="<?php echo $icone_men; ?> navIcone"></i>
                                <span class="nav-titulo"><?php echo $nome_men; ?></span>

                                <i class="fas fa-angle-down seta"></i>
                            </a>
                            <div id="collapse<?php echo $id_men ?>" class="collapse" aria-labelledby="collapseOne<?php echo $id_men ?>" data-parent="#navBarLateral">
                                <div class="card-body ml-4 p-0 pb-3">
                            <?php
                            $cont_drop = $id_men;
                            }
                        }
                        if ($nome_men != "Configuração"){
                        ?>
                            <a href="<?php echo URLADM .$menu_controller.'/'.$menu_metodo; ?>" class="nav-link">
                                <i class="<?php echo $icone_pg; ?>"></i>
                                <span class="nav-titulo"><?php echo $nome_pagina; ?></span>
                            </a>
                        <?php

                        $cont_drop_fech = 1;
                        }

                    } else {

                        if(($cont_drop_fech == 1))
                        {
                            if ($nome_men != "Configuração"){
                            // Fechamento do dropdown
                            echo "</div>";
                            echo "</div>";
                            $cont_drop_fech = 0;
                            }
                        }
                        // link normal, sem modal
                        ?>
                        <a href="<?php echo URLADM .$menu_controller.'/'.$menu_metodo; ?>" class="nav-link py-2">
                            <i class="<?php echo $icone_men; ?> navIcone"></i>
                            <span class="nav-titulo">
                                <?php echo $nome_men; ?>
                            </span>
                        </a>
                        <?php
                    }
                }
                if(($cont_drop_fech == 1))
                {
                    // Fechamento do dropdown
                    echo "</div>";
                    $cont_drop_fech = 0;
                }
                ?>
            </nav>
        </div>
    </section>

    <section id="conteudoMain" class="col container-fluid pr-0">

        <main class="pb-5">
                   
        
        