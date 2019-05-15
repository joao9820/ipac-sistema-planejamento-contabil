<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsHome;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Home
{

    private $Dados;

    public function index()
    {
        $qtdUser = new AdmsHome();
        $qtdUser->verTotUser($_SESSION['adms_empresa_id']);
        $this->Dados['usuarios'] = $qtdUser->getResultado();

        $atendimentos = new AdmsHome();
        $this->Dados['atendimentos_total'] = $atendimentos->verAtendimentos();

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new ConfigView("adms/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}
