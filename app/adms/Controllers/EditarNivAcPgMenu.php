<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 02/02/2019
 * Time: 21:13
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsEditarNivAcPgMenu;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarNivAcPgMenu
{

    private $Dados;
    private $DadosId;
    private $NivId;
    private $PageId;

    public function editNivAcPgMenu($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->NivId = filter_input(INPUT_GET, "niv", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId) AND ! empty($this->NivId) AND ! empty($this->PageId)) {
            $this->editNivAcPgMenuPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu não encontrado!","danger");
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editNivAcPgMenuPriv() {
        if (!empty($this->Dados['EditNivAcPgMenu'])) {
            unset($this->Dados['EditNivAcPgMenu']);

            $editarMenu = new AdmsEditarNivAcPgMenu();
            $editarMenu->altMenu($this->Dados);
            if ($editarMenu->getResultado()) {
                $UrlDestino = URLADM . "permissoes/listar/{$this->PageId}?niv={$this->NivId}";
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editMenuViewPriv();
            }
        } else {
            $verNivAcPg = new AdmsEditarNivAcPgMenu();
            $this->Dados['form'] = $verNivAcPg->verNivAcPg($this->DadosId);
            $this->editMenuViewPriv();
        }
    }

    private function editMenuViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new AdmsEditarNivAcPgMenu();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new \Core\ConfigView("adms/Views/permi/editarNivAcPgMenu", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu não encontrado!","danger");
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}