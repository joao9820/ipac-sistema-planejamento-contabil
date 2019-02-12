<?php
if (!defined('URL')) {
    header("Location: /");
    exit();
}
?>
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
                echo "</div>";
                $cont_drop_fech = 0;
            }
            ?>

            </li>


            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle menu-header" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown">
                    <?php if(isset($_SESSION['usuario_imagem']) AND (!empty($_SESSION['usuario_imagem']))) { ?>
                    <img class="rounded-circle" src="<?php echo URLADM . 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/'. $_SESSION['usuario_imagem'] ?>" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">
                    <?php } else { ?>
                        <img class="rounded-circle" src="<?php echo URLADM . 'assets/imagens/usuario/icone_usuario.jpg'?>" width="20" height="20"> &nbsp;<span class="d-none d-sm-inline">
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