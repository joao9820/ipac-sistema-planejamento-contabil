<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 14:06
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarDemanda
{
    private $DadosId;
    private $Resultado;
    private $DadosUsuario;


    public function getResultado()
    {
        return $this->Resultado;
    }


    public function apagarDemanda($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->verUsuario(); // Apenas por segurança, verificar o nível do usuario para apagar a demanda

        if ($this->DadosUsuario) {

            $this->verificarAtendDemanda();

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você não tem permissão para apagar a demanda selecionada.","danger");
            $this->Resultado = false;

        }


    }

    private function verUsuario()
    {

        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT user.id   
                        FROM adms_usuarios user 
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >=:ordem LIMIT :limit",
            "id=".$_SESSION['usuario_id']."&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->DadosUsuario = $verUsuario->getResultado();
    }

    private function verificarAtendDemanda()
    {
        $verAtendDemanda = new AdmsRead();
        $verAtendDemanda->fullRead("SELECT id FROM adms_atendimentos WHERE adms_demanda_id=:adms_demanda_id LIMIT :limit", "adms_demanda_id={$this->DadosId}&limit=1");
        if ($verAtendDemanda->getResultado())
        {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A demanda selecionada não pode ser apagada. Já tem atendimento registrado com essa demanda","danger");
            $this->Resultado = false;

        }
        else {

            $this->exeApagarDemanda();

        }
    }

    private function exeApagarDemanda()
    {
        $apagarDemanda = new AdmsDelete();
        $apagarDemanda->exeDelete("adms_demandas", "WHERE id=:id", "id={$this->DadosId}");
        if ($apagarDemanda->getResultado())
        {
            $apagarAtividades = new AdmsDelete();
            $apagarAtividades->exeDelete("adms_atividades", "WHERE adms_demanda_id=:id", "id={$this->DadosId}");

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Demanda apagada!","success");
            $this->Resultado = true;

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Ocorreu um erro. A demanda não foi apagada!","danger");
            $this->Resultado = false;

        }
    }

}