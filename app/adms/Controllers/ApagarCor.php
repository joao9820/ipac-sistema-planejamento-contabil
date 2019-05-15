<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:19
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarCor;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarCor
{

    private $DadosId;

    public function apagarCor($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarCor = new AdmsApagarCor();
            $apagarCor->apagarCor($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar uma cor!","danger");
        }
        $UrlDestino = URLADM . 'cor/listar';
        header("Location: $UrlDestino");
    }

}