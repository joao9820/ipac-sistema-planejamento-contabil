<?php

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarNivAc
 *
 * @copyright (c) year, Cesar Szpak - Celke
 */
class AdmsCadastrarAtividade
{

    private $Resultado;
    private $Dados;
    private $UltimaAtiv;


    function getResultado()
    {
        return $this->Resultado;
    }

    public function cadAtividade(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);

        $valCampoVazio = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {

            $this->valNomeAtividadeUnica();

        }
        else {
            $this->Resultado = false;
        }
    }

    private function valNomeAtividadeUnica()
    {
        $valCampoUnico = new \App\adms\Models\helper\AdmsRead();
        $valCampoUnico->fullRead("SELECT id FROM adms_atividades WHERE nome =:nome AND adms_demanda_id =:adms_demanda_id LIMIT :limit", "nome={$this->Dados['nome']}&adms_demanda_id={$this->Dados['adms_demanda_id']}&limit=1");
        //var_dump($valCampoUnico->getResultado());
        if ($valCampoUnico->getResultado()){

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Oops!","Atividade já cadastrada para a demanda selecionada", "danger");
            $this->Resultado = false;

        }
        else {

            $this->inserirAtividade();

        }
    }


    private function inserirAtividade()
    {

        $this->Dados['created'] = date("Y-m-d H:i:s");
        $this->verUltimaAtiv();
        $this->Dados['ordem'] = $this->UltimaAtiv[0]['ordem'] + 1;

        $cadAtividade = new \App\adms\Models\helper\AdmsCreate();
        $cadAtividade->exeCreate("adms_atividades", $this->Dados);

        if ($cadAtividade->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atividade cadastrada com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A atividade não foi cadastrada", "danger");
            $this->Resultado = false;

        }

    }

    private function verUltimaAtiv()
    {
        $verAtiv = new \App\adms\Models\helper\AdmsRead();
        $verAtiv->fullRead("SELECT ordem FROM adms_atividades WHERE adms_demanda_id =:adms_demanda_id ORDER BY ordem DESC LIMIT :limit", "adms_demanda_id={$this->Dados['adms_demanda_id']}&limit=1");
        $this->UltimaAtiv = $verAtiv->getResultado();
        //var_dump($this->UltimaAtiv);
    }



}
