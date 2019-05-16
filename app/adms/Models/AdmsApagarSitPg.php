<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:44
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarSitPg
{

    private $DadosId;
    private $Resultado;

    function getResultado() {
        return $this->Resultado;
    }

    public function apagarSitPg($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $apagarSitPg = new AdmsDelete();
            $apagarSitPg->exeDelete("adms_sits_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarSitPg->getResultado()) {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de página apagado!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de página não foi apagado!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad() {
        $verPg = new AdmsRead();
        $verPg->fullRead("SELECT id FROM adms_paginas
                WHERE adms_sits_pg_id =:adms_sits_pg_id LIMIT :limit", "adms_sits_pg_id=" . $this->DadosId . "&limit=2");
        if ($verPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de página não pode ser apagada, há páginas cadastradas com essa situação!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }


}