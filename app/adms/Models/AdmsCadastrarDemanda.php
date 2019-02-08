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

        } else {
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

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Está demanda já foi cadastrada!</div>";
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
            $_SESSION['msg'] = "<div class='alert alert-success'>Demanda cadastrada com sucesso!</div>";
            $this->Resultado = true;
        }
        else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: A demanda não foi cadastrada!</div>";
            $this->Resultado = false;
        }
    }


    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
        $listar->fullRead("SELECT id id_grpg, nome nome_grpg FROM adms_grps_pgs ORDER BY nome ASC");

        $registro['grpg'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_tpg, tipo tipo_tpg, nome nome_tpg FROM adms_tps_pgs ORDER BY nome ASC");
        $registro['tpg'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sitpg, nome nome_sitpg FROM adms_sits_pgs ORDER BY nome ASC");
        $registro['sitpg'] = $listar->getResultado();

        $this->Resultado = ['grpg' => $registro['grpg'], 'tpg' => $registro['tpg'], 'sitpg' => $registro['sitpg']];

        return $this->Resultado;
    }



}
