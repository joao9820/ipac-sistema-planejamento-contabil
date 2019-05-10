<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsConfirmarEmail;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class Confirmar
{

    private $DadosChave;

    public function confirmarEmail()
    {
        $this->DadosChave = filter_input(INPUT_GET, 'chave', FILTER_SANITIZE_STRING);
        if (!empty($this->DadosChave)) {
            $confEmail = new AdmsConfirmarEmail();
            $confEmail->confirmarEmail($this->DadosChave);
            if ($confEmail->getResultado()) {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            } else {
                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");
            }
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Link de confirmação inválido!","danger");
            $UrlDestino = URLADM . 'login/acesso';
            header("Location: $UrlDestino");
        }
    }

}
