<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 12:44
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarDemanda;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarDemanda
{
    private $DadosId;

    public function apagarDemanda($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $apagarDemanda = new AdmsApagarDemanda();
            $apagarDemanda->apagarDemanda($this->DadosId);

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessario selecionar uma demanda!","danger");

        }
        $UrlDestino = URLADM .'demandas/listar';
        header("Location: $UrlDestino");
    }

}