<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:01
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAltOrdemTipoPg
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosTipoPg;
    private $DadosTipoPgInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemTipoPg($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verTipoPg();
        if ($this->DadosTipoPg) {
            $this->verfTipoPgInferior();
            if ($this->DadosTipoPgInferior) {
                $this->exeAltOrdemTipoPg();
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do tipo de página!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verTipoPg() {
        $verTipoPg = new AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM adms_tps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosTipoPg = $verTipoPg->getResultado();
    }

    private function verfTipoPgInferior() {
        $ordem_super = $this->DadosTipoPg[0]['ordem'] - 1;
        $verTipoPg = new AdmsRead();
        $verTipoPg->fullRead("SELECT id, ordem FROM adms_tps_pgs WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosTipoPgInferior = $verTipoPg->getResultado();
    }

    private function exeAltOrdemTipoPg() {
        $this->Dados['ordem'] = $this->DadosTipoPg[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosTipoPgInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosTipoPg[0]['ordem'] - 1;
        $upMvCima = new AdmsUpdate();
        $upMvCima->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosTipoPg[0]['id']}");

        if ($upMvCima->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Ordem do tipo de página editado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do tipo de página!","danger");
            $this->Resultado = false;
        }
    }

}