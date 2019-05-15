<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:49
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerCor;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerCor
{

    private $Dados;
    private $DadosId;

    public function verCor($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verCor = new AdmsVerCor();
            $this->Dados['dados_cor'] = $verCor->vercor($this->DadosId);

            $botao = ['list_cor' => ['menu_controller' => 'cor', 'menu_metodo' => 'listar'],
                'edit_cor' => ['menu_controller' => 'editar-cor', 'menu_metodo' => 'edit-cor'],
                'del_cor' => ['menu_controller' => 'apagar-cor', 'menu_metodo' => 'apagar-cor']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/cor/verCor", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor não encontrada!","danger");
            $UrlDestino = URLADM . 'cor/listar';
            header("Location: $UrlDestino");
        }
    }


}