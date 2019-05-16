<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsApagarNivAc
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAvInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarNivAc($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfUsuarioCad();
        if ($this->Resultado) {
            $this->verfNivAcInferior();
            $apagarNivAc = new AdmsDelete();
            $apagarNivAc->exeDelete("adms_niveis_acessos", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarNivAc->getResultado()) {
                $this->atualizarOrdem();
                $this->apagarNivAcPg();
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nível de acesso apagado!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nivel de acesso não foi apagado!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verfUsuarioCad()
    {
        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT id FROM adms_usuarios
                WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id LIMIT :limit", "adms_niveis_acesso_id=" . $this->DadosId . "&limit=2");
        if ($verUsuario->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O nível de acesso não pode ser apagado, há usuários cadastrados neste nível!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfNivAcInferior()
    {
        $verNivAc = new AdmsRead();
        $verNivAc->fullRead("SELECT id, ordem AS ordem_result FROM adms_niveis_acessos WHERE ordem > (SELECT ordem FROM adms_niveis_acessos WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosNivAvInferior = $verNivAc->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosNivAvInferior) {
            foreach ($this->DadosNivAvInferior as $atualOrdem) {
                extract($atualOrdem);
                /** @var TYPE_NAME $ordem_result */
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltNivAc = new AdmsUpdate();
                /** @var TYPE_NAME $id */
                $upAltNivAc->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

    private function apagarNivAcPg()
    {
        $apagarNivAcPg = new \App\adms\Models\helper\AdmsDelete();
        $apagarNivAcPg->exeDelete("adms_nivacs_pgs", "WHERE adms_niveis_acesso_id =:adms_niveis_acesso_id", "adms_niveis_acesso_id={$this->DadosId}");
    }

}
