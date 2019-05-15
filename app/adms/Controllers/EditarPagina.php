<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarPagina;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of EditarUsuario
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class EditarPagina
{

    private $Dados;
    private $DadosId;

    public function editPagina($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editPaginaPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Página não encontrada!","danger");
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editPaginaPriv()
    {
        if (!empty($this->Dados['EditPagina'])) {
            unset($this->Dados['EditPagina']);

            $editarPagina = new AdmsEditarPagina();
            $editarPagina->altPagina($this->Dados);
            if ($editarPagina->getResultado()) {
                $UrlDestino = URLADM . 'ver-pagina/ver-pagina/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editPaginaViewPriv();
            }
        } else {
            $verPagina = new AdmsEditarPagina();
            $this->Dados['form'] = $verPagina->verPagina($this->DadosId);
            $this->editPaginaViewPriv();
        }
    }

    private function editPaginaViewPriv()
    {
        if ($this->Dados['form']) {
            $listarSelect = new AdmsEditarPagina();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_pagina' => ['menu_controller' => 'ver-pagina', 'menu_metodo' => 'ver-pagina']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/pagina/editarPagina", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Página não encontrada!","danger");
            $UrlDestino = URLADM . 'pagina/listar';
            header("Location: $UrlDestino");
        }
    }

}
