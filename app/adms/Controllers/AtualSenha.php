<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 23/01/2019
 * Time: 14:50
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsAtualSenha;
use App\adms\Models\helper\AdmsAlertMensagem;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AtualSenha
{

    private $Chave;
    private $Dados;


    public function atualSenha()
    {
        $this->Chave = filter_input(INPUT_GET, "chave", FILTER_SANITIZE_STRING);
        $this->Dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (!empty($this->Chave))
        {

            $validaChave = new AdmsAtualSenha();
            $validaChave->valChave($this->Chave);
            if($validaChave->getResultado())
            {
                $this->atualSenhaPriv();
            }
            else {

                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");

            }

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Link inválido!","danger");
            $UrlDestino = URLADM . 'login/acesso';
            header("Location: $UrlDestino");

        }


    }

    private function atualSenhaPriv()
    {
        if (!empty($this->Dados['AtualSenha']))
        {
            unset($this->Dados['AtualSenha']);
            $this->Dados['recuperar_senha'] = $this->Chave;

            $atualSenha = new AdmsAtualSenha();
            $atualSenha->atualSenha($this->Dados);
            if($atualSenha->getResultado())
            {

                $UrlDestino = URLADM . 'login/acesso';
                header("Location: $UrlDestino");

            }
            else {

                //Carregar a view
                $carregarView = new ConfigView("adms/Views/login/atualSenha", $this->Dados);
                $carregarView->renderizarLogin();

            }
        }
        else {

            //Carregar a view
            $carregarView = new ConfigView("adms/Views/login/atualSenha", $this->Dados);
            $carregarView->renderizarLogin();

        }
    }

}