<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarNivAc;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class ApagarNivAc
{

    private $DadosId;

    public function apagarNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $apagarNivAc = new AdmsApagarNivAc();
           $apagarNivAc->apagarNivAc($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um nível de acesso!","danger");
        }
        $UrlDestino = URLADM . 'nivel-acesso/listar';
        header("Location: $UrlDestino");
    }

}
