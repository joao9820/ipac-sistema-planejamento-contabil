<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:41
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCadastrarTipoPg
{

    private $Resultado;
    private $Dados;
    private $UltimoTipoPg;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadTipoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirTipoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirTipoPg()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoTipoPg();
        $this->Dados['ordem'] = $this->UltimoTipoPg[0]['ordem'] + 1;
        $cadTipoPg = new AdmsCreate;
        $cadTipoPg->exeCreate("adms_tps_pgs", $this->Dados);
        if ($cadTipoPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página cadastrado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página não foi cadastrado.","danger");
            $this->Resultado = false;
        }
    }

    private function verUltimoTipoPg()
    {
        $verTipoPg = new AdmsRead();
        $verTipoPg->fullRead("SELECT ordem FROM adms_tps_pgs ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoTipoPg = $verTipoPg->getResultado();
    }

}