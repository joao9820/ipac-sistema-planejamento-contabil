<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsEditarNivAc;
use App\adms\Models\AdmsMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class EditarNivAc
{

    private $Dados;
    private $DadosId;

    public function editNivAc($DadosId = null)
    {
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $this->editNivAcPriv();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nível de acesso não encontrado!","danger");
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

    private function editNivAcPriv()
    {
        if (!empty($this->Dados['EditNivAc'])) {
            unset($this->Dados['EditNivAc']);

            $editarNivAc = new AdmsEditarNivAc();
            $editarNivAc->altNivAc($this->Dados);
            if ($editarNivAc->getResultado()) {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nível de acesso editado!","success");
                $UrlDestino = URLADM . 'ver-niv-ac/ver-niv-ac/' . $this->Dados['id'];
                header("Location: $UrlDestino");
            } else {
                $this->Dados['form'] = $this->Dados;
                $this->editNivAcViewPriv();
            }
        } else {
            $verNivAc = new AdmsEditarNivAc();
            $this->Dados['form'] = $verNivAc->verNivAc($this->DadosId);
            $this->editNivAcViewPriv();
        }
    }

    private function editNivAcViewPriv()
    {
        if ($this->Dados['form']) {            
            $botao = ['vis_nivac' => ['menu_controller' => 'ver-niv-ac', 'menu_metodo' => 'ver-niv-ac']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();
            $carregarView = new ConfigView("adms/Views/nivAcesso/editarNivAc", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nível de acesso não encontrado!","danger");
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}
