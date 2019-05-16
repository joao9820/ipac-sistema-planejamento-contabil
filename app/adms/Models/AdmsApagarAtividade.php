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

class AdmsApagarAtividade
{
    private $DadosId;
    private $Resultado;
    private $DadosUsuario;


    public function getResultado()
    {
        return $this->Resultado;
    }


    public function apagarAtividade($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->verUsuario(); // Apenas por segurança, verificar o nível do usuario para apagar a demanda

        if ($this->DadosUsuario) {

            $apagarDemanda = new AdmsDelete();
            $apagarDemanda->exeDelete("adms_atividades", "WHERE id=:id", "id={$this->DadosId}");
            if ($apagarDemanda->getResultado())
            {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade apagada!","success");
                $this->Resultado = true;

            } else {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Ocorreu um erro no sistema. Atividade não foi apagada!","danger");
                $this->Resultado = false;

            }

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você não tem permissão para apagar a atividade selecionada!","danger");
            $this->Resultado = false;

        }


    }

    public function verUsuario()
    {

        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT user.id   
                        FROM adms_usuarios user 
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >=:ordem LIMIT :limit",
            "id=".$_SESSION['usuario_id']."&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->DadosUsuario = $verUsuario->getResultado();
    }

}