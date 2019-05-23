<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsEditarNivAc
 *
 */
class AdmsEditarNivAc
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verNivAc($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verPerfil = new AdmsRead();
        $verPerfil->fullRead("SELECT * FROM adms_niveis_acessos
                WHERE id =:id AND ordem >=:ordem LIMIT :limit", "id=" . $this->DadosId . "&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado = $verPerfil->getResultado();
        return $this->Resultado;
    }

    public function altNivAc(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditNivAc();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditNivAc()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltNivAc = new AdmsUpdate();
        $upAltNivAc->exeUpdate("adms_niveis_acessos", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltNivAc->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nível de acesso atualizado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O nível de acesso não foi atualizado.","danger");
            $this->Resultado = false;
        }
    }

}
