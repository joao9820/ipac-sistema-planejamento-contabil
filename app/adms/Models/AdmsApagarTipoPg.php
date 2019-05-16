<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:55
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarTipoPg
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosTipoPgInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarTipoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $this->verfTipoPgInferior();
            $apagarTipoPg = new AdmsDelete();
            $apagarTipoPg->exeDelete("adms_tps_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarTipoPg->getResultado()) {
                $this->atualizarOrdem();
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página apagado!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página não foi apagado!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad()
    {
        $verMenu = new AdmsRead();
        $verMenu->fullRead("SELECT id FROM adms_paginas
                WHERE adms_tps_pg_id =:adms_tps_pg_id LIMIT :limit", "adms_tps_pg_id=" . $this->DadosId . "&limit=2");
        if ($verMenu->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O tipo de página não pode ser apagado, há páginas cadastradas neste tipo de página!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfTipoPgInferior()
    {
        $verTipoPg = new AdmsRead();
        $verTipoPg->fullRead("SELECT id, ordem AS ordem_result FROM adms_tps_pgs WHERE ordem > (SELECT ordem FROM adms_tps_pgs WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosTipoPgInferior = $verTipoPg->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosTipoPgInferior) {
            foreach ($this->DadosTipoPgInferior as $atualOrdem) {
                extract($atualOrdem);
                /** @var TYPE_NAME $ordem_result */
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltTipoPg = new \App\adms\Models\helper\AdmsUpdate();
                /** @var TYPE_NAME $id */
                $upAltTipoPg->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}