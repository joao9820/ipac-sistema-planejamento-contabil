<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 26/01/2019
 * Time: 18:31
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;
use App\adms\Models\helper\AdmsValSenha;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarSenha
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosUsuario;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valUsuario($DadosId)
    {

        $this->DadosId = (int) $DadosId;
        $validaUsuario = new AdmsRead();
        $validaUsuario->fullRead("SELECT user.id  
                        FROM adms_usuarios user 
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >:ordem LIMIT :limit",
            "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->DadosUsuario = $validaUsuario->getResultado();
        if (!empty($this->DadosUsuario))
        {

            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário não encontrado.","danger");
            $this->Resultado = false;

        }

    }

    public function editSenha(array $Dados)
    {
        $this->Dados = $Dados;
        $valCampoVazio = new AdmsCampoVazio();
        $valCampoVazio->validarDados($this->Dados);
        if ($valCampoVazio->getResultado()){

            $valSenha = new AdmsValSenha();
            $valSenha->valSenha($this->Dados['senha']);

            if ($valSenha->getResultado()) {

                $this->updateEditSenha();

            }
            else {

                $this->Resultado = false;

            }

        } else {

            $this->Resultado = false;

        }

    }

    private function updateEditSenha()
    {
        $this->valUsuario($this->Dados['id']);
        if($this->Resultado) {

            $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
            $this->Dados['modified'] = date('Y-m-d H:i:s');
            $upAtualSenha = new AdmsUpdate();
            $upAtualSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
            if ($upAtualSenha->getResultado()) {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Senha atualizada!","success");
                $this->Resultado = true;

            }
            else {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("A senha não foi atualizada.","danger");
                $this->Resultado = false;

            }

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A senha não foi atualizada. Tente novamente!","danger");
            $this->Resultado = false;

        }

    }


}