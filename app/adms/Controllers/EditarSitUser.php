<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:27
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarSitUser;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarSitUser
{

    private $Dados;
    private $DadosId;

    public function editSitUser($DadosId = null) {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editSitUserPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de usuário não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao-user/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editSitUserPriv() {
        if (!empty($this->Dados['EditSitUser'])) {
            unset($this->Dados['EditSitUser']);

            $editarSitUser = new AdmsEditarSitUser();
            $editarSitUser->altSitUser($this->Dados);
            if ($editarSitUser->getResultado()) {
                $UrlDestino = URLADM . 'ver-sit-user/ver-sit-user/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editSitUserViewPriv();
            }
        } else {
            $verSitUser = new AdmsEditarSitUser();
            $this->Dados['form'] = $verSitUser->verSitUser($this->DadosId);
            $this->editSitUserViewPriv();
        }
    }

    private function editSitUserViewPriv() {
        if ($this->Dados['form']) {
            $listarSelect = new AdmsEditarSitUser();
            $this->Dados['select'] = $listarSelect->listarCadastrar();

            $botao = ['vis_sit' => ['menu_controller' => 'ver-sit-user', 'menu_metodo' => 'ver-sit-user']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/situacaoUser/editarSitUser", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de usuário não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao-user/listar';
            header("Location: $UrlDestino");
        }
    }

}