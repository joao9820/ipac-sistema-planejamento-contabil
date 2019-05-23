<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarNivAc
 *
 */
class AdmsCadastrarNivAc
{

    private $Resultado;
    private $Dados;
    private $UltimoNivAc;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadNivAc(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirNivAc();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirNivAc()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoNivAc();
        $this->Dados['ordem'] = $this->UltimoNivAc[0]['ordem'] + 1;
        $cadNivAc = new AdmsCreate;
        $cadNivAc->exeCreate("adms_niveis_acessos", $this->Dados);
        if ($cadNivAc->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Nível de acesso cadastrado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O nível de acesso não foi cadastrado.","danger");
            $this->Resultado = false;
        }
    }
    
    private function verUltimoNivAc()
    {
        $verNivAc = new AdmsRead();
        $verNivAc->fullRead("SELECT ordem FROM adms_niveis_acessos ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoNivAc = $verNivAc->getResultado();
    }

}
