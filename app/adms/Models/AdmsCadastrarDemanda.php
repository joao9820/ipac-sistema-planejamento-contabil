<?php

namespace App\adms\Models;

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

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio();
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
        $valCampoUnico = new \App\adms\Models\helper\AdmsValCampoUnico();
        $valCampoUnico->valCampo("adms_demandas", "nome",$this->Dados['nome'], $EditarUnico);

        if ($valCampoUnico->getResultado()){

            $this->inserirDemanda();

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Oops!","Está demanda já foi cadastrada", "danger");
            $this->Resultado = false;

        }
    }


    private function inserirDemanda()
    {
        $this->Dados['adms_usuario_id'] = $_SESSION['usuario_id'];
        $this->Dados['created'] = date("Y-m-d H:i:s");
        //var_dump($this->Dados);

        $cadDemanda = new \App\adms\Models\helper\AdmsCreate();
        $cadDemanda->exeCreate("adms_demandas", $this->Dados);

        if ($cadDemanda->getResultado())
        {

            $this->UltimoIdInserido = $cadDemanda->getResultado();
            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Demanda cadastrada com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A demanda não foi cadastrada", "danger");
            $this->Resultado = false;

        }
    }


}
