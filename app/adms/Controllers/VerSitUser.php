<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:20
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerSitUser;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerSitUser
{

    private $Dados;
    private $DadosId;

    public function verSitUser($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSitUser = new AdmsVerSitUser();
            $this->Dados['dados_sit'] = $verSitUser->verSitUser($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao-user', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit-user', 'menu_metodo' => 'edit-sit-user'],
                'del_sit' => ['menu_controller' => 'apagar-sit-user', 'menu_metodo' => 'apagar-sit-user']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/situacaoUser/verSitUser", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de usuário não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao-user/listar';
            header("Location: $UrlDestino");
        }
    }

}