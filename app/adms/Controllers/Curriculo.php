<?php

namespace App\adms\Controllers;

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

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $curriculo = new  \App\adms\Models\AdmsListarCurriculos();
        $this->Dados['curriculo'] = $curriculo->listarCurriculo();

        $carregarView = new \Core\ConfigView("adms/Views/curriculo/curriculo", $this->Dados);
        $carregarView->renderizar();
    }

}
