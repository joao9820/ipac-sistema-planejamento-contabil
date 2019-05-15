<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerPagina;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerPagina
{

    private $Dados;
    private $DadosId;

    public function verPagina($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verPagina = new AdmsVerPagina();
            $this->Dados['dados_pagina'] = $verPagina->verPagina($this->DadosId);

            $botao = ['list_pagina' => ['menu_controller' => 'pagina', 'menu_metodo' => 'listar'],
                'edit_pagina' => ['menu_controller' => 'editar-pagina', 'menu_metodo' => 'edit-pagina'],
                'edit_pagina' => ['menu_controller' => 'editar-pagina', 'menu_metodo' => 'edit-pagina'],
                'del_pagina' => ['menu_controller' => 'apagar-pagina', 'menu_metodo' => 'apagar-pagina']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/pagina/verPagina", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Página não encontrada!","danger");
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

}
