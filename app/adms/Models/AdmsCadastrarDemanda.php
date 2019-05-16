<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsValCampoUnico;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCadastrarDemanda
{

    private $Resultado;
    private $Dados;
    private $UltimoIdInserido;


    function getResultado()
    {
        return $this->Resultado;
    }


    public function cadDemanda(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {

            $this->valNomeDemandaUnico();

        }
        else {

            $this->Resultado = false;

        }
    }

    private function valNomeDemandaUnico()
    {
        $EditarUnico = false;
        $valCampoUnico = new AdmsValCampoUnico();
        $valCampoUnico->valCampo("adms_demandas", "nome",$this->Dados['nome'], $EditarUnico);

        if ($valCampoUnico->getResultado()){

            $this->inserirDemanda();

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Está demanda já foi cadastrada!","danger");
            $this->Resultado = false;

        }
    }


    private function inserirDemanda()
    {
        $this->Dados['adms_usuario_id'] = $_SESSION['usuario_id'];
        $this->Dados['created'] = date("Y-m-d H:i:s");
        //var_dump($this->Dados);

        $cadDemanda = new AdmsCreate();
        $cadDemanda->exeCreate("adms_demandas", $this->Dados);

        if ($cadDemanda->getResultado())
        {

            $this->UltimoIdInserido = $cadDemanda->getResultado();
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Demanda cadastrada!","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A demanda não foi cadastrada. Tente novamente mais tarde!","danger");
            $this->Resultado = false;

        }
    }


}
