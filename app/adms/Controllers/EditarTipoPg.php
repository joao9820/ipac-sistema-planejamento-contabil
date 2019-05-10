<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:43
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarTipoPg;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarTipoPg
{

    private $Dados;
    private $DadosId;

    public function editTipoPg($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editTipoPgPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página não encontrado!","danger");
            $UrlDestino = URLADM . 'tipo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editTipoPgPriv() {
        if (!empty($this->Dados['EditTipoPg'])) {
            unset($this->Dados['EditTipoPg']);

            $editarTipoPg = new AdmsEditarTipoPg();
            $editarTipoPg->altTipoPg($this->Dados);
            if ($editarTipoPg->getResultado()) {
                $UrlDestino = URLADM . 'ver-tipo-pg/ver-tipo-pg/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editTipoPgViewPriv();
            }
        } else {
            $verTipoPg = new AdmsEditarTipoPg();
            $this->Dados['form'] = $verTipoPg->verTipoPg($this->DadosId);
            $this->editTipoPgViewPriv();
        }
    }

    private function editTipoPgViewPriv() {
        if ($this->Dados['form']) {

            $botao = ['vis_tpg' => ['menu_controller' => 'ver-tipo-pg', 'menu_metodo' => 'ver-tipo-pg']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/tipoPg/editarTipoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página não encontrado!","danger");
            $UrlDestino = URLADM . 'tipo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}