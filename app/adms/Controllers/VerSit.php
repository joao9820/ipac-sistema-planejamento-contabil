<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:06
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerSit;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerSit
{

    private $Dados;
    private $DadosId;

    public function verSit($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSit = new AdmsVerSit();
            $this->Dados['dados_sit'] = $verSit->verSit($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit', 'menu_metodo' => 'edit-sit'],
                'del_sit' => ['menu_controller' => 'apagar-sit', 'menu_metodo' => 'apagar-sit']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/situacao/verSit", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao/listar';
            header("Location: $UrlDestino");
        }
    }

}