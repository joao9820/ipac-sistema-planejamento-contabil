<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
<?php
    if(isset($_SESSION['msg'])) {
        echo $_SESSION['msg'];
        unset($_SESSION['msg']);
        $_SESSION['alert'] = "ok";
    }
?>
<!-- Mensagem de alerta atividade em andamento -->
<div id='mensagemCardAviso' class='card border-warning bg-warning d-none'>
    <div class='card-body text-light text-center' style='position: relative; min-width: 300px !important;'>
        <div onclick='fecharAgoraAviso()' class='text-right' style='position: absolute; top: 5px; right: 10px'>
            <i class='fas fa-times' style='cursor: pointer;'></i>
        </div>
        <i class='fas fa-exclamation-triangle fa-2x'></i>
        <h5 class='card-title' >Atividade em execução</h5>
        <p class='card-text'>Não esqueça de finalizar sua atividade quando a mesma for concluída.</p>
    </div>
</div>



<!-- Navigation -->
<header class="nav-cabecalho container-fluid px-0">
        <div class="row mx-0 px-0">
            <div id="navLogo" class="logo-admin d-mobile-none">
                <a href="<?php echo URLADM . 'home/index' ?>">
                    <img class="img-fluid" src="<?php echo URLADM . 'assets/imagens/logo_login/logo-ipac.png'; ?>" alt="IPAC">
                </a>
            </div>
            <div class="col px-0 mx-0 nav-menu border-bottom">
                <div class="ml-4 d-mobile-none" onclick="MostrarEsconderDiv()" style="cursor:pointer;">
                    <i class="fas fa-bars"></i>
                </div>

                <!-- Menu Mobile -->
                <li class="nav-item dropdown no-arrow mx-1 drop-down-menu d-md-none">
                    <a id="dropDown-menu" class="nav-link dropdown-toggle text-white">

                        <span class="img-fluid">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" viewBox="0 0 64 64" enable-background="new 0 0 64 64">
                            <g>
                                <g fill="#1D1D1B">
                                <path d="m23.967,34.025h-17.967c-3.309,0-6,2.691-6,6v17.975c0,3.309 2.691,6 6,6h17.967c3.309,0 6-2.691 6-6v-17.975c0-3.308-2.692-6-6-6zm2,23.975c0,1.103-0.896,2-2,2h-17.967c-1.104,0-2-0.897-2-2v-17.975c0-1.103 0.896-2 2-2h17.967c1.104,0 2,0.897 2,2v17.975z" fill="#FFFFFF"/>
                                <path d="m58,34.025h-17.969c-3.309,0-6,2.691-6,6v17.975c0,3.309 2.691,6 6,6h17.969c3.309,0 6-2.691 6-6v-17.975c0-3.308-2.691-6-6-6zm2,23.975c0,1.103-0.898,2-2,2h-17.969c-1.102,0-2-0.897-2-2v-17.975c0-1.103 0.898-2 2-2h17.969c1.102,0 2,0.897 2,2v17.975z" fill="#FFFFFF"/>
                                <path d="m23.967,0h-17.967c-3.309,0-6,2.691-6,6v17.969c0,3.309 2.691,6 6,6h17.967c3.309,0 6-2.691 6-6v-17.969c0-3.309-2.692-6-6-6zm2,23.969c0,1.103-0.896,2-2,2h-17.967c-1.104,0-2-0.897-2-2v-17.969c0-1.103 0.896-2 2-2h17.967c1.104,0 2,0.897 2,2v17.969z" fill="#FFFFFF"/>
                                <path d="M58,0H40.031c-3.309,0-6,2.691-6,6v17.969c0,3.309,2.691,6,6,6H58c3.309,0,6-2.691,6-6V6    C64,2.691,61.309,0,58,0z M60,23.969c0,1.103-0.898,2-2,2H40.031c-1.102,0-2-0.897-2-2V6c0-1.103,0.898-2,2-2H58    c1.102,0,2,0.897,2,2V23.969z" fill="#FFFFFF"/>
                                </g>
                            </g>
                            </svg>
                        </span>
            
                    </a>
                    <!-- SUB MENU JQUERY -->
                    <div class="drop-down__menu-box">
                        <div class="drop-down__menu">
                            <div class="row p-3  d-flex flex-row justify-content-between flex-wrap">
                                <div class="card mb-2 card-mobile-conteudo col-12 px-0 border-bottom">
                                    <div class="text-center mb-4 p-0">
                                        
                                        <!-- Perfil -->
                                        <a href="<?php echo URLADM . 'ver-perfil/perfil' ?>" class="mt-4  d-flex flex-row justify-content-left">
                                            <div>
                                                <figure class="text-center">
                                                    <?php if(isset($_SESSION['usuario_imagem']) AND (!empty($_SESSION['usuario_imagem']))) { ?>
                                                        <img class="img-fluid img-menu-mobile" src="<?php echo URLADM . 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/'. $_SESSION['usuario_imagem'] ?>" width="20" height="20">
                                                    <?php } else { ?>
                                                            <img class="img-fluid img-menu-mobile" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.jpg'?>" width="20" height="20">
                                                    <?php } ?>
                                                </figure>
                                            </div>
                                            <div id="perfilNavMobile" class="d-flex flex-column text-center text-secondary">
                                                <span class="small">Bem vindo(a)</span>
                                                <small class="">
                                                    <?php
                                                        $nome = explode(" ", $_SESSION['usuario_nome']);
                                                        $prim_nome = $nome[0];
                                                        echo $prim_nome; 
                                                    ?>
                                                </small>
                                                <span id="tipoPerfil" class="mt-2">
                                                    <small><i class="far fa-id-badge"></i> 
                                                        <?php
                                                            if ($_SESSION['nome_nivel']) {
                                                                echo $_SESSION['nome_nivel'];
                                                            }
                                                        ?>
                                                    </small>
                                                </span>
                                            </div>
                                            <span id="engrenagem" class="text-secondary"><i class="fas fa-cog"></i></span>
                                        </a><!-- Fim Perfil-->
                                        
                                    </div>
                                </div>
                                <div class="d-flex flex-column">
                                    <p>
                                        <button class="btn btn-powercar btn-sm" type="button" data-toggle="collapse" data-target="#menuCollapse" aria-expanded="false" aria-controls="menuCollapse">Menu</button>
                                    </p>
                                    <div class="collapse" id="menuCollapse">
                                        <div class="card  card-mobile-conteudo  col-12" >
                                            <div class="card-body p-0">
                                                <div class="conainer-mobile-link">

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
                                                                    //echo "</div>";

                                                                    $cont_drop_fech = 0;
                                                                }
                                                                ?>
                                                                <div class="tiulo-mobile-link">
                                                                    <a  onclick="event.preventDefault();" href="#">
                                                                        <i class="<?php echo $icone_men; ?>"></i> <?php echo $nome_men; ?>
                                                                    </a>
                                                                </div>
                                                                <ul>
                                                                <?php
                                                                $cont_drop = $id_men;
                                                            }
                                                            ?>
                                                                <li>
                                                                    <a  class="link-mobile" href="<?php echo URLADM .$menu_controller.'/'.$menu_metodo; ?>">
                                                                    <i class="<?php echo $icone_pg; ?>"></i> <?php echo $nome_pagina; ?></a>
                                                                </li>

                                                            <?php

                                                            $cont_drop_fech = 1;

                                                        } else {

                                                            if(($cont_drop_fech == 1))
                                                            {
                                                                // Fechamento do dropdown
                                                                echo "</ul>";
                                                                //echo "</div>";
                                                                $cont_drop_fech = 0;
                                                            }
                                                            // link normal, sem modal
                                                            ?>
                                                            <div class="tiulo-mobile-link">
                                                                <a href="<?php echo URLADM .$menu_controller.'/'.$menu_metodo; ?>">
                                                                    <i class="<?php echo $icone_men; ?>"></i> <?php echo $nome_men; ?>
                                                                </a>
                                                            </div>
                                                            <?php
                                                        }
                                                    }
                                                    if(($cont_drop_fech == 1))
                                                    {
                                                        // Fechamento do dropdown
                                                        echo "</ul>";
                                                        $cont_drop_fech = 0;
                                                    }
                                                    ?>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                </li>

                <div class="mobile-logo-admin d-md-none mx-auto">
                    <a href="<?php echo URLADM . 'home/index' ?>">
                        <img class="img-fluid" src="<?php echo URLADM . 'assets/imagens/logo_login/logo-ipac.png'; ?>" alt="IPAC">
                    </a>
                </div>
                <?php if ($_SESSION['adms_niveis_acesso_id'] <= 3){ ?>
                    <div class="d-none d-md-block ml-auto mr-5 dropdown dropleft">
                        <a id="iconeNav" href="#" class="linkMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Configuração <i class="fas fa-cogs"></i>
                        </a>
                        <div id="cardConfig" class="dropdown-menu" aria-labelledby="iconeNav">
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
                                            //echo "</div>";
                                            //echo "</div>";

                                            $cont_drop_fech = 0;
                                        }
                                        $cont_drop = $id_men;
                                    }
                                    if ($nome_men == "Configuração") {
                                        # code...
                                    ?>
                                        <a href="<?php echo URLADM .$menu_controller.'/'.$menu_metodo; ?>" class="dropdown-item text-secondary">
                                            <i class="<?php echo $icone_pg; ?>"></i> <?php echo $nome_pagina; ?>
                                        </a>
                                    <?php
                                    }
                                    $cont_drop_fech = 1;

                                } else {

                                    if(($cont_drop_fech == 1))
                                    {
                                        // Fechamento do dropdown
                                        $cont_drop_fech = 0;
                                    }
                                    // link normal, sem modal
                                }
                            }
                            if(($cont_drop_fech == 1))
                            {
                                // Fechamento do dropdown
                                $cont_drop_fech = 0;
                            }
                            ?>

                        </div>
                    </div>
                    <div class="mr-4 text-white">
                        <a id="iconeNav" href="<?php echo URLADM . "login/logout"; ?>" class="linkMenu">
                            Sair <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                <?php } else { ?>
                    <div class="ml-auto mr-4 text-white">
                        <a id="iconeNav" href="<?php echo URLADM . "login/logout"; ?>" class="linkMenu">
                        Sair <i class="fas fa-sign-out-alt"></i>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </header>





<!--
<nav class="navbar navbar-expand navbar-dark">
    <a class="sidebar-toggle mr-3 text-danger cursor">
        <span class="navbar-toggler-icon "></span>
    </a>
    <a class="navbar-brand" href="#">
        <img id="img-ipac" src="<?php echo URLADM . 'assets/imagens/logo_login/ipacAzul.jpg'; ?>" class="img-fluid img-ipac">
    </a>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link  menu-header" href="#" id="dropdownMenu" data-toggle="dropdown">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" viewBox="0 0 64 64" enable-background="new 0 0 64 64">
                            <g>
                              <g fill="#1D1D1B">
                                <path d="m23.967,34.025h-17.967c-3.309,0-6,2.691-6,6v17.975c0,3.309 2.691,6 6,6h17.967c3.309,0 6-2.691 6-6v-17.975c0-3.308-2.692-6-6-6zm2,23.975c0,1.103-0.896,2-2,2h-17.967c-1.104,0-2-0.897-2-2v-17.975c0-1.103 0.896-2 2-2h17.967c1.104,0 2,0.897 2,2v17.975z" fill="#FFFFFF"/>
                                <path d="m58,34.025h-17.969c-3.309,0-6,2.691-6,6v17.975c0,3.309 2.691,6 6,6h17.969c3.309,0 6-2.691 6-6v-17.975c0-3.308-2.691-6-6-6zm2,23.975c0,1.103-0.898,2-2,2h-17.969c-1.102,0-2-0.897-2-2v-17.975c0-1.103 0.898-2 2-2h17.969c1.102,0 2,0.897 2,2v17.975z" fill="#FFFFFF"/>
                                <path d="m23.967,0h-17.967c-3.309,0-6,2.691-6,6v17.969c0,3.309 2.691,6 6,6h17.967c3.309,0 6-2.691 6-6v-17.969c0-3.309-2.692-6-6-6zm2,23.969c0,1.103-0.896,2-2,2h-17.967c-1.104,0-2-0.897-2-2v-17.969c0-1.103 0.896-2 2-2h17.967c1.104,0 2,0.897 2,2v17.969z" fill="#FFFFFF"/>
                                <path d="M58,0H40.031c-3.309,0-6,2.691-6,6v17.969c0,3.309,2.691,6,6,6H58c3.309,0,6-2.691,6-6V6    C64,2.691,61.309,0,58,0z M60,23.969c0,1.103-0.898,2-2,2H40.031c-1.102,0-2-0.897-2-2V6c0-1.103,0.898-2,2-2H58    c1.102,0,2,0.897,2,2V23.969z" fill="#FFFFFF"/>
                              </g>
                            </g>
                          </svg>
                    </span>
                    <span class="d-none d-sm-inline">Menu</span>
                </a>
                <div class='dropdown-menu dropdown-menu-right' aria-labelledby='dropdownMenu'>
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

                                    $cont_drop_fech = 0;
                                }
                                // Menu Paginas
                                echo "<span class='dropdown-item mr-5 text-secondary'  href='#'>";
                                    // Itens de menu
                                    echo "<i class='".$icone_men." '></i> ".$nome_men;
                                echo "</span>";
                                $cont_drop = $id_men;
                            }

                            //Sub menu links
                            echo "<a class='dropdown-item' href='" . URLADM .$menu_controller."/".$menu_metodo."'><i class='ml-3 ".$icone_pg."'></i> ".$nome_pagina." </a>";

                            $cont_drop_fech = 1;

                        } else {

                            if(($cont_drop_fech == 1))
                            {
                                //echo "</div>";
                                $cont_drop_fech = 0;
                            }
                            // Link Sair
                            echo "<a class='dropdown-item' href='" . URLADM .$menu_controller."/".$menu_metodo."'><i class='".$icone_men."'></i> ".$nome_men."</a>";

                        }
                    }
                    if(($cont_drop_fech == 1))
                    {
                        // Fechamento do dropdown
                        echo "</div>"; // div que feicha a div que contem todo menu
                        $cont_drop_fech = 0;
                    }
                ?>

            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    <?php if(isset($_SESSION['usuario_imagem']) AND (!empty($_SESSION['usuario_imagem']))) { ?>
                    <img class="rounded-circle imgPerfil" src="<?php echo URLADM . 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/'. $_SESSION['usuario_imagem'] ?>" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">
                    <?php } else { ?>
                        <img class="rounded-circle  imgPerfil" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.jpg'?>" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">
                    <?php } ?>
                        <?php
                        $nome = explode(" ", $_SESSION['usuario_nome']);
                        $prim_nome = $nome[0];
                        echo $prim_nome; ?>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo URLADM . "ver-perfil/perfil"; ?>"><i class="fas fa-user"></i> Perfil</a>
                    <a class="dropdown-item" href='<?php echo URLADM . "login/logout"; ?>'><i class="fas fa-sign-out-alt"></i> Sair</a>
                </div>
            </li>
        </ul>

    </div>
</nav>
                    -->