<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:34
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarGrupoPg;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarGrupoPg
{

    private $DadosId;

    public function apagarGrupoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarGrupoPg = new AdmsApagarGrupoPg();
            $apagarGrupoPg->apagarGrupoPg($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um grupo de página!","danger");
        }
        $UrlDestino = URLADM . 'grupo-pg/listar';
        header("Location: $UrlDestino");
    }

}