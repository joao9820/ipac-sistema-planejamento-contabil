<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:41
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarSitPg;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarSitPg
{

    private $Dados;
    private $DadosId;

    public function editSitPg($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitPgPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de página não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao-pg/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitPgPriv() {
        if (!empty($this->Dados['EditSitPg'])) {
            unset($this->Dados['EditSitPg']);
            $editarSitPg = new AdmsEditarSitPg();
            $editarSitPg->altSitPg($this->Dados);
            if ($editarSitPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit-pg/ver-sit-pg/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitPgViewPriv();
            }
        } else {
            $verSitPg = new AdmsEditarSitPg();
            $this->Dados['form'] = $verSitPg->verSitPg($this->DadosId);
            $this->editSitPgViewPriv();
        }
    }

    private function editSitPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_sit' => ['menu_controller' => 'ver-sit-pg', 'menu_metodo' => 'ver-sit-pg']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/situacaoPg/editarSitPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de página não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}