<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:27
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerGrupoPg;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerGrupoPg
{

    private $Dados;
    private $DadosId;

    public function verGrupoPg($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verGrupoPg = new AdmsVerGrupoPg();
            $this->Dados['dados_grpg'] = $verGrupoPg->verGrupoPg($this->DadosId);

            $botao = ['list_grpg' => ['menu_controller' => 'grupo-pg', 'menu_metodo' => 'listar'],
                'edit_grpg' => ['menu_controller' => 'editar-grupo-pg', 'menu_metodo' => 'edit-grupo-pg'],
                'del_grpg' => ['menu_controller' => 'apagar-grupo-pg', 'menu_metodo' => 'apagar-grupo-pg']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/grupoPg/verGrupoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página não encontrado!","danger");
            $UrlDestino = URLADM . 'grupo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}