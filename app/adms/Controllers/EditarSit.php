<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:11
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarSit;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarSit
{

    private $Dados;
    private $DadosId;

    public function editSit($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação não encontrada!","danger");
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: !</div>";
            $UrlDestino = URLADM . 'situacao/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitPriv() {
        if (!empty($this->Dados['EditSit'])) {
            unset($this->Dados['EditSit']);

            $editarSit = new AdmsEditarSit();
            $editarSit->altSit($this->Dados);
            if ($editarSit->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit/ver-sit/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitViewPriv();
            }
        } else {
            $verSit = new AdmsEditarSit();
            $this->Dados['form'] = $verSit->verSit($this->DadosId);
            $this->editSitViewPriv();
        }
    }

    private function editSitViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new AdmsEditarSit();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_sit' => ['menu_controller' => 'ver-sit', 'menu_metodo' => 'ver-sit']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/situacao/editarSit", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação não encontrada!","danger");
            $UrlDestino = URLADM . 'situacao/listar';
            header("Location: $UrlDestino");
        }
    }

}