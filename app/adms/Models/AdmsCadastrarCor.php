<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:12
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCadastrarCor
{

    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadCor(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->inserirCor();
        } else {
            $this->Resultado = false;
        }
    }

    private function inserirCor()
    {
        $this->Dados['created'] = date("Y-m-d H:i:s");
        $cadCor = new AdmsCreate;
        $cadCor->exeCreate("adms_cors", $this->Dados);
        if ($cadCor->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor cadastrada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A cor não foi cadastrada.","danger");
            $this->Resultado = false;
        }
    }

}