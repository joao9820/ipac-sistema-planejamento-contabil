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

class AdmsEditarAtividade
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verAtividade($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT * 
                        FROM adms_atividades  
                        WHERE id =:id LIMIT :limit",
            "id={$this->DadosId}&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function altAtividade(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampos = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampos->validarDados($this->Dados);

        if ($valCampos->getResultado()) {

            $this->valCampos();

        }
        else {

            $this->Resultado = false;
        }

    }


    private function valCampos()
    {

        $valCampoUnico = new \App\adms\Models\helper\AdmsRead();
        $valCampoUnico->fullRead("SELECT id 
                        FROM adms_atividades 
                        WHERE id <>:id AND nome =:nome AND adms_demanda_id =:adms_demanda_id LIMIT :limit",
            "id={$this->Dados['id']}&nome={$this->Dados['nome']}&adms_demanda_id={$this->Dados['adms_demanda_id']}&limit=1");

        //var_dump($this->Dados);

        if ($valCampoUnico->getResultado()){

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","Atividade já cadastrada para a demanda selecionada", "danger");
            $this->Resultado = false;


        }
        else {

            $this->updateEditAtividade();

        }

    }


    private function updateEditAtividade()
    {
        $this->Dados['modified'] = date('Y-m-d H:i:s');


        $upEditAtividade = new \App\adms\Models\helper\AdmsUpdate();

        $upEditAtividade->exeUpdate("adms_atividades", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditAtividade->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atividade atualizada com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A atividade não foi atualizada", "danger");
            $this->Resultado = false;

        }

    }







}