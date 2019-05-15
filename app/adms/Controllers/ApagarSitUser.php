<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:31
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarSitUser;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarSitUser
{

    private $DadosId;

    public function apagarSitUser($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarSitUser = new AdmsApagarSitUser();
            $apagarSitUser->apagarSitUser($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar uma situação de usuário!","danger");
        }
        $UrlDestino = URLADM . 'situacao-user/listar';
        header("Location: $UrlDestino");
    }

}