<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsListarPagina;
use App\adms\Models\AdmsMenu;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class Pagina
{

    private $Dados;
    private $PageId;

    public function listar($PageId = null)
    {
        $this->PageId = (int) $PageId ? $PageId : 1;

        $botao = ['cad_pagina' => ['menu_controller' => 'cadastrar-pagina', 'menu_metodo' => 'cad-pagina'],
            'vis_pagina' => ['menu_controller' => 'ver-pagina', 'menu_metodo' => 'ver-pagina'],
            'edit_pagina' => ['menu_controller' => 'editar-pagina', 'menu_metodo' => 'edit-pagina'],
            'del_pagina' => ['menu_controller' => 'apagar-pagina', 'menu_metodo' => 'apagar-pagina']];
        $listarBotao = new AdmsBotao();
        $this->Dados['botao'] = $listarBotao->valBotao($botao);
        //var_dump($this->Dados['botao']);

        $listarMenu = new AdmsMenu();
        $this->Dados['menu'] = $listarMenu->itemMenu();

        $listarPagina = new AdmsListarPagina();
        $this->Dados['listPagina'] = $listarPagina->listarPagina($this->PageId);
        $this->Dados['paginacao'] = $listarPagina->getResultadoPg();

        $carregarView = new ConfigView("adms/Views/pagina/listarPagina", $this->Dados);
        $carregarView->renderizar();
    }

}
