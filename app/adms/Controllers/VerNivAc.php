<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerNivAc;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerNivAc
{

    private $Dados;
    private $DadosId;

    public function verNivAc($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verNivAc = new AdmsVerNivAc();
            $this->Dados['dados_nivac'] = $verNivAc->verNivAc($this->DadosId);

            $botao = ['list_nivac' => ['menu_controller' => 'nivel-acesso', 'menu_metodo' => 'listar'],
                'edit_nivac' => ['menu_controller' => 'editar-niv-ac', 'menu_metodo' => 'edit-niv-ac'],
                'del_nivac' => ['menu_controller' => 'apagar-niv-ac', 'menu_metodo' => 'apagar-niv-ac']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/nivAcesso/verNivAc", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nivel de acesso não encontrado!","danger");
            $UrlDestino = URLADM . 'nivel-acesso/listar';
            header("Location: $UrlDestino");
        }
    }

}
