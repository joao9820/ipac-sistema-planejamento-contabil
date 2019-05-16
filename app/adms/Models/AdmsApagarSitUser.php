<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:31
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarSitUser
{

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSitUser($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfUsuarioCad();
        if ($this->Resultado) {
            $apagarSitUser = new AdmsDelete();
            $apagarSitUser->exeDelete("adms_sits_usuarios", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarSitUser->getResultado()) {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de usuário apagada!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de usuário não foi apagado!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verfUsuarioCad() {
        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT id FROM adms_usuarios
                WHERE adms_sits_usuario_id =:adms_sits_usuario_id LIMIT :limit", "adms_sits_usuario_id=" . $this->DadosId . "&limit=2");
        if ($verUsuario->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de usuário não pode ser apagada, há usuários cadastrados com essa situação!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}