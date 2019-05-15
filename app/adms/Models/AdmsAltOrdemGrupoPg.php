<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:36
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAltOrdemGrupoPg
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosGrupoPg;
    private $DadosGrupoPgInferior;

    function getResultado() {
        return $this->Resultado;
    }

    public function altOrdemGrupoPg($DadosId = null) {
        $this->DadosId = (int) $DadosId;
        $this->verGrupoPg($this->DadosId);
        if ($this->DadosGrupoPg) {
            $this->verfGrupoPgInferior();
            if ($this->DadosGrupoPgInferior) {
                $this->exeAltOrdemGrupoPg();
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do grupo de página!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verGrupoPg() {
        $verGrupoPg = new AdmsRead();
        $verGrupoPg->fullRead("SELECT * FROM adms_grps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->DadosGrupoPg = $verGrupoPg->getResultado();
    }

    private function verfGrupoPgInferior() {
        $ordem_super = $this->DadosGrupoPg[0]['ordem'] - 1;
        $verGrupoPg = new AdmsRead();
        $verGrupoPg->fullRead("SELECT id, ordem FROM adms_grps_pgs WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosGrupoPgInferior = $verGrupoPg->getResultado();
    }

    private function exeAltOrdemGrupoPg() {
        $this->Dados['ordem'] = $this->DadosGrupoPg[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_grps_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosGrupoPgInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosGrupoPg[0]['ordem'] - 1;
        $upMvCima = new AdmsUpdate();
        $upMvCima->exeUpdate("adms_grps_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosGrupoPg[0]['id']}");

        if ($upMvCima->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Ordem do grupo de página editado!","succss");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do grupo de página!","danger");
            $this->Resultado = false;
        }
    }

}