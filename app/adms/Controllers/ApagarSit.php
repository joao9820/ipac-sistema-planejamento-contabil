<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:14
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarSit;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarSit
{

    private $DadosId;

    public function apagarSit($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarSit = new AdmsApagarSit();
            $apagarSit->apagarSit($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar uma situação!","danger");
        }
        $UrlDestino = URLADM . 'situacao/listar';
        header("Location: $UrlDestino");
    }

}