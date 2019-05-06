<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarAtividade
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $DemandaId;
    private $Sucessora;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verAtividade($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT * 
                        FROM adms_atividades  
                        WHERE id =:id LIMIT :limit",
            "id={$this->DadosId}&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function listarAtividades($DadosId, $DemandaId)
    {
        $this->DadosId = (int) $DadosId;
        $this->DemandaId = (int) $DemandaId;

        $listar = new AdmsRead();
        $listar->fullRead("SELECT id, nome, atividade_sucessora_id
                        FROM adms_atividades  
                        WHERE adms_demanda_id=:adms_demanda_id 
                        AND id<>:id ",
            "adms_demanda_id={$this->DemandaId}&id={$this->DadosId}");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function altAtividade(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampos = new AdmsCampoVazio();
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

        $valCampoUnico = new AdmsRead();
        $valCampoUnico->fullRead("SELECT id 
                        FROM adms_atividades 
                        WHERE id <>:id AND nome =:nome AND adms_demanda_id =:adms_demanda_id LIMIT :limit",
            "id={$this->Dados['id']}&nome={$this->Dados['nome']}&adms_demanda_id={$this->Dados['adms_demanda_id']}&limit=1");

        //var_dump($this->Dados);

        if ($valCampoUnico->getResultado()){

            $alertMensagem = new AdmsAlertMensagem();
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

        $this->verificarSucessora();
        if ($this->Sucessora){
            $alertMensagem = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Essa atividade já é sucessora da atividade selecionada. Por tanto não pode ter a mesma como sucessora.", "danger");
            return $this->Resultado = false;

        } else {
            echo "não existe continue";
            //die;
        }

        $upEditAtividade = new AdmsUpdate();

        $upEditAtividade->exeUpdate("adms_atividades", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditAtividade->getResultado())
        {

            $alertMensagem = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atividade atualizada com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A atividade não foi atualizada", "danger");
            $this->Resultado = false;

        }

    }

    private function verificarSucessora()
    {
        $verif = new AdmsRead();
        $verif->fullRead("SELECT id 
                        FROM adms_atividades 
                        WHERE id=:id AND atividade_sucessora_id =:atividade_editar LIMIT :limit",
            "id={$this->Dados['atividade_sucessora_id']}&atividade_editar={$this->Dados['id']}&limit=1");
        $this->Sucessora =$verif->getResultado();
    }







}