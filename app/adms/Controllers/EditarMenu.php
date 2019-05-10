<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:09
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarMenu;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarMenu
{

    private $Dados;
    private $DadosId;

    public function editMenu($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editMenuPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu não encontrado!","danger");
            $UrlDestino = URLADM . 'menu/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editMenuPriv() {
        if (!empty($this->Dados['EditMenu'])) {
            unset($this->Dados['EditMenu']);

            $editarMenu = new AdmsEditarMenu();
            $editarMenu->altMenu($this->Dados);
            if ($editarMenu->getResultado()) {
                $UrlDestino = URLADM . 'ver-menu/ver-menu/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMenuViewPriv();
            }
        } else {
            $verMenu = new AdmsEditarMenu();
            $this->Dados['form'] = $verMenu->verMenu($this->DadosId);
            $this->editMenuViewPriv();
        }
    }

    private function editMenuViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new AdmsEditarMenu();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_menu' => ['menu_controller' => 'ver-menu', 'menu_metodo' => 'ver-menu']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/menu/editarMenu", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu não encontrado!","danger");
            $UrlDestino = URLADM . 'menu/listar';
            header("Location: $UrlDestino");
        }
    }

}