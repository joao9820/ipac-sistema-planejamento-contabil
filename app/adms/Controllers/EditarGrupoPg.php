<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:32
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarGrupoPg;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarGrupoPg
{

    private $Dados;
    private $DadosId;

    public function editGrupoPg($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editGrupoPgPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página não encontrado!","danger");
            $UrlDestino = URLADM . 'grupo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editGrupoPgPriv() {
        if (!empty($this->Dados['EditGrupoPg'])) {
            unset($this->Dados['EditGrupoPg']);

            $editarGrupoPg = new AdmsEditarGrupoPg();
            $editarGrupoPg->altGrupoPg($this->Dados);
            if ($editarGrupoPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-grupo-pg/ver-grupo-pg/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editGrupoPgViewPriv();
            }
        } else {
            $verGrupoPg = new AdmsEditarGrupoPg();
            $this->Dados['form'] = $verGrupoPg->verGrupoPg($this->DadosId);
            $this->editGrupoPgViewPriv();
        }
    }

    private function editGrupoPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_grpg' => ['menu_controller' => 'ver-grupo-pg', 'menu_metodo' => 'ver-grupo-pg']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/grupoPg/editarGrupoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página não encontrado!","danger");
            $UrlDestino = URLADM . 'grupo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}