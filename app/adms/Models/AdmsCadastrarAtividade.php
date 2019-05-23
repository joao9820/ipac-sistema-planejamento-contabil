<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsCadastrarNivAc
 *
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

        $valCampoVazio = new AdmsCampoVazio();
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
        $valCampoUnico = new AdmsRead();
        $valCampoUnico->fullRead("SELECT id FROM adms_atividades WHERE nome =:nome AND adms_demanda_id =:adms_demanda_id LIMIT :limit", "nome={$this->Dados['nome']}&adms_demanda_id={$this->Dados['adms_demanda_id']}&limit=1");
        //var_dump($valCampoUnico->getResultado());
        if ($valCampoUnico->getResultado()){

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade já cadastrada para a demanda selecionada!","danger");
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

        $cadAtividade = new AdmsCreate();
        $cadAtividade->exeCreate("adms_atividades", $this->Dados);

        if ($cadAtividade->getResultado())
        {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade cadastrada !","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A atividade não foi cadastrada!","danger");
            $this->Resultado = false;

        }

    }

    private function verUltimaAtiv()
    {
        $verAtiv = new AdmsRead();
        $verAtiv->fullRead("SELECT ordem FROM adms_atividades WHERE adms_demanda_id =:adms_demanda_id ORDER BY ordem DESC LIMIT :limit", "adms_demanda_id={$this->Dados['adms_demanda_id']}&limit=1");
        $this->UltimaAtiv = $verAtiv->getResultado();
        //var_dump($this->UltimaAtiv);
    }



}
