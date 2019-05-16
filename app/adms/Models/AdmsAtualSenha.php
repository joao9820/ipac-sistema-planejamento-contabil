<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 23/01/2019
 * Time: 15:05
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;
use App\adms\Models\helper\AdmsValSenha;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAtualSenha
{

    private $Chave;
    private $DadosUsuario;
    private $Resultado;
    private $Dados;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valChave($Chave)
    {
        $this->Chave = (string) $Chave;
        $validaChave = new AdmsRead();
        $validaChave->fullRead("SELECT id FROM adms_usuarios WHERE recuperar_senha =:recuperar_senha LIMIT :limit", "recuperar_senha={$this->Chave}&limit=1");
        $this->DadosUsuario = $validaChave->getResultado();
        if (!empty($this->DadosUsuario))
        {
            $this->Resultado = true;
        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Link inválido!","danger");
            $this->Resultado = false;

        }
    }

    public function atualSenha(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if ($this->Resultado)
        {
            $valSenha = new AdmsValSenha();
            $valSenha->valSenha($this->Dados['senha']);
            if ($valSenha->getResultado())
            {

                $this->updateAtualSenha();

            }
            else {
                $this->Resultado = false;
            }
        }
    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if(in_array('', $this->Dados)){

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário preencher todos os campos!","warning");
            $this->Resultado = false;

        }
        else {

            $this->Resultado = true;

        }

    }

    private function updateAtualSenha()
    {
        $this->valChave($this->Dados['recuperar_senha']);
        if($this->Resultado)
        {

            $this->Dados['recuperar_senha'] = NULL;
            $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
            $this->Dados['modified'] = date('Y-m-d H:i:s');
            $upAtualSenha = new AdmsUpdate();
            $upAtualSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->DadosUsuario[0]['id']}");
            if ($upAtualSenha->getResultado()) {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Senha atualizada!","success");
                $this->Resultado = true;

            } else {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("A senha não foi atualizada.","danger");
                $this->Resultado = false;
            }

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Algo deu errado. A senha não foi atualizada. Tente novamente mais tarde!","danger");
            $this->Resultado = false;

        }

    }


}