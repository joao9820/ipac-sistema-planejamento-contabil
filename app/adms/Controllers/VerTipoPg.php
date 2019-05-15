<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:47
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsBotao;
use App\adms\Models\AdmsMenu;
use App\adms\Models\AdmsVerTipoPg;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class VerTipoPg
{

    private $Dados;
    private $DadosId;

    public function verTipoPg($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verTipoPg = new AdmsVerTipoPg();
            $this->Dados['dados_tpg'] = $verTipoPg->verTipoPg($this->DadosId);

            $botao = ['list_tpg' => ['menu_controller' => 'tipo-pg', 'menu_metodo' => 'listar'],
                'edit_tpg' => ['menu_controller' => 'editar-tipo-pg', 'menu_metodo' => 'edit-tipo-pg'],
                'del_tpg' => ['menu_controller' => 'apagar-tipo-pg', 'menu_metodo' => 'apagar-tipo-pg']];
            $listarBotao = new AdmsBotao();
            $this->Dados['botao'] = $listarBotao->valBotao($botao);

            $listarMenu = new AdmsMenu();
            $this->Dados['menu'] = $listarMenu->itemMenu();

            $carregarView = new ConfigView("adms/Views/tipoPg/verTipoPg", $this->Dados);
            $carregarView->renderizar();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página não encontrado!","danger");
            $UrlDestino = URLADM . 'tipo-pg/listar';
            header("Location: $UrlDestino");
        }
    }

}