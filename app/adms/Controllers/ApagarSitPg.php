<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:44
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsApagarSitPg;
use App\adms\Models\helper\AdmsAlertMensagem;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class ApagarSitPg
{

    private $DadosId;

    public function apagarSitPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $apagarSitPg = new AdmsApagarSitPg();
            $apagarSitPg->apagarSitPg($this->DadosId);
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário selecionar uma situação de página!","danger");
        }
        $UrlDestino = URLADM . 'situacao-pg/listar';
        header("Location: $UrlDestino");
    }

}