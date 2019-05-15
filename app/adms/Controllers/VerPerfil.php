<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 14:05
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerPerfil;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerPerfil
{

    private $Dados;

    public function perfil()
    {
        $verPerfil = new AdmsVerPerfil();
        $this->Dados['dados_perfil'] = $verPerfil->verPerfil();

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView('adms/Views/usuario/perfil', $this->Dados);
        $carregarView->renderizar();
    }

}