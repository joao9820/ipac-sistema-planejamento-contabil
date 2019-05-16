<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:29
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

class AdmsCadastrarGrupoPg
{

    private $Resultado;
    private $Dados;
    private $UltimoGrupoPg;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadGrupoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirGrupoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirGrupoPg()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimoGrupoPg();
        $this->Dados['ordem'] = $this->UltimoGrupoPg[0]['ordem'] + 1;
        $cadGrupoPg = new AdmsCreate;
        $cadGrupoPg->exeCreate("adms_grps_pgs", $this->Dados);
        if ($cadGrupoPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página cadastrado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página não foi cadastrado!","danger");
            $this->Resultado = false;
        }
    }

    private function verUltimoGrupoPg()
    {
        $verGrupoPg = new AdmsRead();
        $verGrupoPg->fullRead("SELECT ordem FROM adms_grps_pgs ORDER BY ordem DESC LIMIT :limit", "limit=1");
        $this->UltimoGrupoPg = $verGrupoPg->getResultado();
    }

}