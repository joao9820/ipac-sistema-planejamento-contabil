<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:14
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarSit
{

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSit($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $apagarSit = new AdmsDelete();
        $apagarSit->exeDelete("adms_sits", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarSit->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação apagada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação não foi apagada!","danger");
            $this->Resultado = false;
        }
    }


}