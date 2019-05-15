<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:37
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerSitPg;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerSitPg
{

    private $Dados;
    private $DadosId;

    public function verSitPg($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verSitPg = new AdmsVerSitPg();
            $this->Dados['dados_sit'] = $verSitPg->verSitPg($this->DadosId);

            $botao = ['list_sit' => ['menu_controller' => 'situacao-pg', 'menu_metodo' => 'listar'],
                'edit_sit' => ['menu_controller' => 'editar-sit-pg', 'menu_metodo' => 'edit-sit-pg'],
                'del_sit' => ['menu_controller' => 'apagar-sit-pg', 'menu_metodo' => 'apagar-sit-pg']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/situacaoPg/verSitPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de página não encontrado!","danger");
            $UrlDestino = URLADM . 'situacao-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}