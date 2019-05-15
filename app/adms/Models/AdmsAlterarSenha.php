<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsUpdate;
use App\adms\Models\helper\AdmsValSenha;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAlterarSenha
{

    private $Resultado;
    private $Dados;

    public function getResultado()
    {
        return $this->Resultado;
    }



    public function altSenha(array $Dados)
    {
        $this->Dados = $Dados;

        $valSenha = new AdmsValSenha();
        $valSenha->valSenha($this->Dados['senha']);

        if ($valSenha->getResultado()) {
            // se retornar true
            $this->updateAltSenha();

        } else {

            $this->Resultado = false;
        }

    }

    private function updateAltSenha()
    {
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
        $this->Dados['modified'] = date('Y-m-d H:i:s');
        $upAltSenha = new AdmsUpdate();
        $upAltSenha->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$_SESSION['usuario_id']}");
        if ($upAltSenha->getResultado()) {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Senha atualizada!","success");
            $this->Resultado = true;

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A senha não foi atualizada!","danger");
            $this->Resultado = false;

        }

    }



}