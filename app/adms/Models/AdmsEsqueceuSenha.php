<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 23/01/2019
 * Time: 13:10
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsEsqueceuSenha
{
    private $Resultado;
    private $DadosUsuario;
    private $Dados;
    private $DadosEmail;
    private $DadosUdate;


    public function getResultado()
    {
        return $this->Resultado;
    }


    public function esqueceuSenha(array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if($this->Resultado)
        {

            $esqSenha = new \App\adms\Models\helper\AdmsRead();
            $esqSenha->fullRead("SELECT id, nome, usuario, recuperar_senha FROM adms_usuarios WHERE email =:email LIMIT :limit", "email={$this->Dados['email']}&limit=1");
            $this->DadosUsuario = $esqSenha->getResultado();
            if (!empty($this->DadosUsuario)) {

                $this->valChaveRecSenha();

            }
            else {

                $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
                $_SESSION['msg'] = $alertMensagem->alertMensagem("Oops!","E-mail não cadastrado", "danger");
                $this->Resultado = false;

            }

        }

    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if(in_array('', $this->Dados))
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Oops!","Necessário preencher todos os campos", "danger");
            $this->Resultado = false;

        }
        else {

            $valEmail = new \App\adms\Models\helper\AdmsEmail();
            $valEmail->valEmail($this->Dados['email']);
            if($valEmail->getResultado()){

                $this->Resultado = true;

            }
            else {

                $this->Resultado = false;

            }

        }

    }


    private function valChaveRecSenha()
    {
        if (!empty($this->DadosUsuario[0]['recuperar_senha'])){

            $this->dadosEmail();

        }
        else
        {
            $this->DadosUdate['recuperar_senha'] = md5($this->DadosUsuario[0]['id'] . date('Y-m-d H:i'));
            $this->DadosUdate['modified'] = date('Y-m-d H:i');

            $updateRecSenha = new \App\adms\Models\helper\AdmsUpdate();
            $updateRecSenha->exeUpdate("adms_usuarios", $this->DadosUdate, "WHERE id =:id", "id={$this->DadosUsuario[0]['id']}");
            if ($updateRecSenha->getResultado())
            {

                $this->DadosUsuario[0]['recuperar_senha'] = $this->DadosUdate['recuperar_senha'];
                $this->dadosEmail();

            }
            else {

                $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
                $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe!","Ocorreu um erro ao recuperar a senha", "danger");
                $this->Resultado = false;

            }
        }
    }


    private function dadosEmail()
    {

        $nome = explode(" ", $this->DadosUsuario[0]['nome']);
        $pri_nome = $nome[0];
        $this->DadosEmail['dest_nome'] = $pri_nome;
        $this->DadosEmail['dest_email'] = $this->Dados['email'];
        $this->DadosEmail['titulo_email'] = "Recuperar senha";
        $this->DadosEmail['cont_email'] = "Olá ". $pri_nome . "<br><br>";
        $this->DadosEmail['cont_email'] .= "Você solicitou uma alteração de senha.<br>";
        $this->DadosEmail['cont_email'] .= "Seguindo o link abaixo você poderá alterar sua senha.<br>";
        $this->DadosEmail['cont_email'] .= "Para continuar o processo de recuperação de sua senha, clique no link abaixo ou cole o endereço abaixo no seu navegador.<br><br>";
        $this->DadosEmail['cont_email'] .= "<a href='".URLADM."atual-senha/atual-senha?chave=".$this->DadosUsuario[0]['recuperar_senha']."'>Clique aqui</a>";
        $this->DadosEmail['cont_email'] .= "<br><br>Usuário: " . $this->DadosUsuario[0]['usuario'] . "<br><br>";
        $this->DadosEmail['cont_email'] .= "Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá a mesma até que você ative este código.<br><br>";

        $this->DadosEmail['cont_text_email'] = "Olá " . $pri_nome . " Você solicitou uma alteração de senha. Seguindo o link abaixo você poderá alterar sua senha.";
        $this->DadosEmail['cont_text_email'] .= "Para continuar o processo de recuperação de sua senha, copie e cole o endereço abaixo no seu navegador.";
        $this->DadosEmail['cont_text_email'] .= URLADM . "atual-senha/atual-senha?chave=" .$this->DadosUsuario[0]['recuperar_senha'] ;
        $this->DadosEmail['cont_text_email'] .= "Usuário: " . $this->DadosUsuario[0]['usuario'] . " . Se você não solicitou essa alteração, nenhuma ação é necessária.";
        $this->DadosEmail['cont_text_email'] .= "Sua senha permanecerá a mesma até que você ative este código.";


        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);

        if($emailPHPMailer->getResultado())
        {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("E-mail enviado com sucesso, verifique sua caixa de entrada", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe!","Erro ao recuperar a senha", "danger");
            $this->Resultado = false;

        }
    }


}