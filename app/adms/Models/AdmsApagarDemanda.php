<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 27/01/2019
 * Time: 14:06
 */

namespace App\adms\Models;

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

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe!","Você não tem permissão para apagar a demanda selecionada", "danger");
            $this->Resultado = false;

        }


    }

    private function verUsuario()
    {

        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT user.id   
                        FROM adms_usuarios user 
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >=:ordem LIMIT :limit",
            "id=".$_SESSION['usuario_id']."&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->DadosUsuario = $verUsuario->getResultado();
    }

    private function verificarAtendDemanda()
    {
        $verAtendDemanda = new \App\adms\Models\helper\AdmsRead();
        $verAtendDemanda->fullRead("SELECT id FROM adms_atendimentos WHERE adms_demanda_id=:adms_demanda_id LIMIT :limit", "adms_demanda_id={$this->DadosId}&limit=1");
        if ($verAtendDemanda->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! A demanda selecionada não pode ser apagada.","Já tem atendimento registrado com essa demanda", "danger");
            $this->Resultado = false;

        }
        else {

            $this->exeApagarDemanda();

        }
    }

    private function exeApagarDemanda()
    {
        $apagarDemanda = new \App\adms\Models\helper\AdmsDelete();
        $apagarDemanda->exeDelete("adms_demandas", "WHERE id=:id", "id={$this->DadosId}");
        if ($apagarDemanda->getResultado())
        {
            $apagarAtividades = new \App\adms\Models\helper\AdmsDelete();
            $apagarAtividades->exeDelete("adms_atividades", "WHERE adms_demanda_id=:id", "id={$this->DadosId}");

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Demanda apagada com sucesso", "success");
            $this->Resultado = true;

        } else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","A demanda não foi apagada", "success");
            $this->Resultado = false;

        }
    }

}