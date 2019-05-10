<?php

namespace App\adms\Controllers;

use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AltOrdemNivAc
{

    private $DadosId;

    public function altOrdemNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
           $altOrdemNivAc = new \App\adms\Models\AdmsAltOrdemNivAc();
           $altOrdemNivAc->altOrdemNivAc($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar um nível de acesso!","danger");
        }
        $UrlDestino = URLADM . 'nivel-acesso/listar';
        header("Location: $UrlDestino");
    }

}
