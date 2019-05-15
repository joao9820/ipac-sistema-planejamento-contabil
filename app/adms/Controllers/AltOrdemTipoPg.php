<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:00
 */

namespace App\adms\Controllers;

use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AltOrdemTipoPg
{

    private $DadosId;

    public function altOrdemTipoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $altOrdemTipoPg = new \App\adms\Models\AdmsAltOrdemTipoPg();
            $altOrdemTipoPg->altOrdemTipoPg($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um tipo de página!","danger");
        }
        $UrlDestino = URLADM . 'tipo-pg/listar';
        header("Location: $UrlDestino");
    }

}