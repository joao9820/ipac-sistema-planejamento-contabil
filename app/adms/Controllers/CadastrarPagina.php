<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsCadastrarPagina;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class CadastrarPagina
{

    private $Dados;

    public function cadPagina()
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Dados['CadPagina'])) {
            unset($this->Dados['CadPagina']);
            $cadPagina = new AdmsCadastrarPagina();
            $cadPagina->cadPagina($this->Dados);
            if ($cadPagina->getResultado()) {
                $UrlDestino = URLADM . 'pagina/listar';
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->cadPaginaViewPriv();
            }
        } else {
            $this->cadPaginaViewPriv();
        }
    }

    private function cadPaginaViewPriv()
    {
        $listarSelect = new AdmsCadastrarPagina();
        $this->Dados['select'] = $listarSelect->listarCadastrar();
       
        $botao = ['list_pagina' => ['menu_controller' => 'pagina', 'menu_metodo' => 'listar']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        
        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $carregarView = new ConfigView("adms/Views/pagina/cadPagina", $this->Dados);
        $carregarView->renderizar();
    }

}
