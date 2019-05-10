<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:28
 */

namespace App\adms\Controllers;

use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AltOrdemItemMenu
{

    private $DadosId;

    public function altOrdemItemMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altOrdemMenu = new \App\adms\Models\AdmsAltOrdemItemMenu();
            $altOrdemMenu->altOrdemMenu($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um item de menu!","danger");
        }
        $UrlDestino = URLADM . 'menu/listar';
        header("Location: $UrlDestino");
    }

}