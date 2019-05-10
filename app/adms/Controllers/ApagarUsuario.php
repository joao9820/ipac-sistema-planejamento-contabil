<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 12:44
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarUsuario;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarUsuario
{
    private $DadosId;

    public function apagarUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId))
        {

            $apagarUsuario = new AdmsApagarUsuario();
            $apagarUsuario->apagarUsuario($this->DadosId);

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessario selecionar um usuário!","danger");

        }
        $UrlDestino = URLADM .'usuarios/listar';
        header("Location: $UrlDestino");
    }

}