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

class AdmsApagarUsuario
{
    private $DadosId;
    private $Resultado;
    private $DadosUsuario;


    public function getResultado()
    {
        return $this->Resultado;
    }


    public function apagarUsuario($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->verUsuario();

        if ($this->DadosUsuario) {

            $apagarUsuario = new \App\adms\Models\helper\AdmsDelete();
            $apagarUsuario->exeDelete("adms_usuarios", "WHERE id=:id", "id={$this->DadosId}");
            if ($apagarUsuario->getResultado()) {
                // Apagar a imagem antiga se existir
                $apagar = new \App\adms\Models\helper\AdmsApagarImg();
                $apagar->apagarImg('assets/imagens/usuario/' . $this->DadosId . '/' . $this->DadosUsuario[0]['imagem'], 'assets/imagens/usuario/' . $this->DadosId);

                $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
                $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Usuário apagado com sucesso", "success");
                $this->Resultado = true;

            }
            else {

                $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
                $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","O usuário não foi apagado", "danger");
                $this->Resultado = false;

            }

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","Você não tem permissão para apagar o usuário selecionado", "danger");
            $this->Resultado = false;

        }


    }

    public function verUsuario()
    {

        $verUsuario = new \App\adms\Models\helper\AdmsRead();
        $verUsuario->fullRead("SELECT user.imagem   
                        FROM adms_usuarios user 
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >:ordem LIMIT :limit",
            "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->DadosUsuario = $verUsuario->getResultado();
    }

}