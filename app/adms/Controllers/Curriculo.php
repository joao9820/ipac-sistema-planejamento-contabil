<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsListarCurriculos;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Curriculo
{

    private $Dados;
    private $PageId;

    public function index($PageId = null)
    {

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $curriculo = new  AdmsListarCurriculos();
        $this->Dados['curriculo'] = $curriculo->listarCurriculo();

        $carregarView = new ConfigView("adms/Views/curriculo/curriculo", $this->Dados);
        $carregarView->renderizar();
    }

}
