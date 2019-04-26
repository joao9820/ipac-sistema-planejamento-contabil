<?php

namespace App\adms\Controllers;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Home
{

    private $Dados;

    public function index()
    {
        $qtdUser = new \App\adms\Models\AdmsHome();
        $qtdUser->verTotUser($_SESSION['adms_empresa_id']);
        $this->Dados['usuarios'] = $qtdUser->getResultado();

        $atendimentos = new \App\adms\Models\AdmsHome();
        $this->Dados['atendimentos_total'] = $atendimentos->verAtendimentos();

        $listarMenu = new \App\adms\Models\AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();
        
        $carregarView = new \Core\ConfigView("adms/Views/home/home", $this->Dados);
        $carregarView->renderizar();
    }

}
