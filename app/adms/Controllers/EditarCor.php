<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:52
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarCor;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class EditarCor
{

    private $Dados;
    private $DadosId;

    public function editCor($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editCorPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor não encontrada!","danger");
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editCorPriv()
    {
        if (!empty($this->Dados['EditCor'])) {
            unset($this->Dados['EditCor']);
            $editarCor = new AdmsEditarCor();
            $editarCor->altCor($this->Dados);
            if ($editarCor->getResultado()) {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor editada!","success");
                $UrlDestino = URLADM . 'ver-cor/ver-cor/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editCorViewPriv();
            }
        } else {
            $verCor = new AdmsEditarCor();
            $this->Dados['form'] = $verCor->verCor($this->DadosId);
            $this->editCorViewPriv();
        }
    }

    private function editCorViewPriv()
    {
        if ($this->Dados['form']) {
            $botao = ['vis_cor' => ['menu_controller' => 'ver-cor', 'menu_metodo' => 'ver-cor']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/cor/editarCor", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor não encontrada!","danger");
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }

}