<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:52
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarTipoPg;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarTipoPg
{

    private $DadosId;

    public function apagarTipoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarTipoPg = new AdmsApagarTipoPg();
            $apagarTipoPg->apagarTipoPg($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um tipo de página!","danger");
        }
        $UrlDestino = URLADM . 'tipo-pg/listar';
        header("Location: $UrlDestino");
    }

}