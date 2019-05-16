<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:34
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarGrupoPg
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosGrupoPgInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarGrupoPg($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $this->verfGrupoPgInferior();
            $apagarGrupoPg = new AdmsDelete();
            $apagarGrupoPg->exeDelete("adms_grps_pgs", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarGrupoPg->getResultado()) {
                $this->atualizarOrdem();
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página apagado!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página não foi apagado!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad()
    {
        $verMenu = new AdmsRead();
        $verMenu->fullRead("SELECT id FROM adms_paginas
                WHERE adms_grps_pg_id =:adms_grps_pg_id LIMIT :limit", "adms_grps_pg_id=" . $this->DadosId . "&limit=2");
        if ($verMenu->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O grupo de página não pode ser apagado, há páginas cadastradas neste grupo de página!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfGrupoPgInferior()
    {
        $verGrupoPg = new AdmsRead();
        $verGrupoPg->fullRead("SELECT id, ordem AS ordem_result FROM adms_grps_pgs WHERE ordem > (SELECT ordem FROM adms_grps_pgs WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosGrupoPgInferior = $verGrupoPg->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosGrupoPgInferior) {
            foreach ($this->DadosGrupoPgInferior as $atualOrdem) {
                extract($atualOrdem);
                /** @var TYPE_NAME $ordem_result */
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltGrupoPg = new AdmsUpdate();
                /** @var TYPE_NAME $id */
                $upAltGrupoPg->exeUpdate("adms_grps_pgs", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}