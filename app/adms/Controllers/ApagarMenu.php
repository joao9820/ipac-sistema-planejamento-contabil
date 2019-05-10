<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:23
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarMenu;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarMenu
{

    private $DadosId;

    public function apagarMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarMenu = new AdmsApagarMenu();
            $apagarMenu->apagarMenu($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um item de menu!","danger");
        }
        $UrlDestino = URLADM . 'menu/listar';
        header("Location: $UrlDestino");
    }


}