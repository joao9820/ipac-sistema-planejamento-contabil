<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:20
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarCor
{

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarCor($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarCor = new AdmsDelete();
        $apagarCor->exeDelete("adms_cors", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarCor->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor apagada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A cor não foi apagada!","danger");
            $this->Resultado = false;
        }
    }

}