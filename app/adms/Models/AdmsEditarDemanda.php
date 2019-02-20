<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarDemanda
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verDemanda($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT dmd.* 
                        FROM adms_demandas dmd 
                        WHERE dmd.id =:id LIMIT :limit",
            "id={$this->DadosId}&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function altDemanda(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $valCampos = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampos->validarDados($this->Dados);

        if ($valCampos->getResultado()) {
            // se retornar true
            $this->valCampos();

        }
        else {

            $this->Resultado = false;
        }

    }


    private function valCampos()
    {
        $EditarUnico = true;

        $valCampoUnico = new \App\adms\Models\helper\AdmsValCampoUnico();
        $valCampoUnico->valCampo("adms_demandas", "nome",$this->Dados['nome'], $EditarUnico, $this->Dados['id']);

        if ($valCampoUnico->getResultado()){

            $this->updateEditDemanda();

        }
        else {

            $this->Resultado = false;
        }


    }


    private function updateEditDemanda()
    {
        $this->Dados['modified'] = date('Y-m-d H:i:s');


        $upEditDemanda = new \App\adms\Models\helper\AdmsUpdate();
        //var_dump($this->Dados);
        $upEditDemanda->exeUpdate("adms_demandas", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditDemanda->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Demanda atualizada com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A demanda não foi atualizada", "danger");
            $this->Resultado = false;

        }

    }







}