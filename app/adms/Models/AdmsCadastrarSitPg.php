<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:39
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCadastrarSitPg
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadSitPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirSitPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirSitPg()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadSitPg = new AdmsCreate;
        $cadSitPg->exeCreate("adms_sits_pgs", $this->Dados);
        if ($cadSitPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de página cadastrada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de página não foi cadastrado.","danger");
            $this->Resultado = false;
        }
    }

}