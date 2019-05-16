<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarNivAc
 *
 */
class AdmsAltOrdemNivAc
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAc;
    private $DadosNivAvInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altOrdemNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verNivAc($this->DadosId);
        if ($this->DadosNivAc) {
            $this->verfNivAcInferior();
            $this->exeAltOrdemNivAc();
        }
    }

    private function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verNivAc = new AdmsRead();
        $verNivAc->fullRead("SELECT * FROM adms_niveis_acessos
                WHERE id =:id AND ordem >:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=" . $_SESSION['ordem_nivac'] . "&limit=1");
        $this->DadosNivAc = $verNivAc->getResultado();
    }

    private function verfNivAcInferior()
    {
        $ordem_super = $this->DadosNivAc[0]['ordem'] - 1;
        $verNivAc = new AdmsRead();
        $verNivAc->fullRead("SELECT id, ordem FROM adms_niveis_acessos WHERE ordem =:ordem", "ordem={$ordem_super}");
        $this->DadosNivAvInferior = $verNivAc->getResultado();
    }

    private function exeAltOrdemNivAc()
    {
        $this->Dados['ordem'] = $this->DadosNivAc[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id={$this->DadosNivAvInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosNivAc[0]['ordem'] - 1;
        $upMvCima = new AdmsUpdate();
        $upMvCima->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id={$this->DadosNivAc[0]['id']}");

        if ($upMvCima->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Ordem do nível de acesso editado!","success");
                $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do nível de acesso!","danger");
                $this->Resultado = false;
        }
    }

}
