<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:40
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarConfEmail
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verConfEmail()
    {
        $verConfEmail = new AdmsRead();
        $verConfEmail->fullRead("SELECT * FROM adms_confs_emails
                WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->Resultado = $verConfEmail->getResultado();
        return $this->Resultado;
    }

    public function altConfEmail(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateConfEmail();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateConfEmail()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upConfEmail = new AdmsUpdate();
        $upConfEmail->exeUpdate("adms_confs_emails", $this->Dados, "WHERE id =:id", "id=1");
        if ($upConfEmail->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Formulário para editar os dados do servidor de e-mail atualizado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Formulário para editar os dados do servidor de e-mail não foi atualizado.","danger");
            $this->Resultado = false;
        }
    }

}