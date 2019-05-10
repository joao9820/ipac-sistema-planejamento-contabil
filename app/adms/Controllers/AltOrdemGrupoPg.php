<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:35
 */

namespace App\adms\Controllers;

use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AltOrdemGrupoPg
{

    private $DadosId;

    public function altOrdemGrupoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altOrdemGrupoPg = new \App\adms\Models\AdmsAltOrdemGrupoPg();
            $altOrdemGrupoPg->altOrdemGrupoPg($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um grupo de página!","danger");
        }
        $UrlDestino = URLADM . 'grupo-pg/listar';
        header("Location: $UrlDestino");
    }

}