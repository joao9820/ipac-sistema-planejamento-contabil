<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:04
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerMenu;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerMenu
{

    private $Dados;
    private $DadosId;

    public function verMenu($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verMenu = new AdmsVerMenu();
            $this->Dados['dados_menu'] = $verMenu->verMenu($this->DadosId);

            $botao = ['list_menu' => ['menu_controller' => 'menu', 'menu_metodo' => 'listar'],
                'edit_menu' => ['menu_controller' => 'editar-menu', 'menu_metodo' => 'edit-menu'],
                'del_menu' => ['menu_controller' => 'apagar-menu', 'menu_metodo' => 'apagar-menu']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/menu/verMenu", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu não encontrado!","danger");
            $UrlDestino = URLADM . 'menu/listar';
            header("Location: $UrlDestino");
        }
    }

}