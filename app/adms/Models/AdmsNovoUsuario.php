<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 21/01/2019
 * Time: 15:38
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsNovoUsuario
{
    private $Dados;
    private $Resultado;
    private $IfoCadUser;
    private $DadosEmail;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function cadUser( array $Dados)
    {
        $this->Dados = $Dados;
        $this->validarDados();
        if($this->Resultado){

            $valEmail = new \App\adms\Models\helper\AdmsEmail();
            $valEmail->valEmail($this->Dados['email']);

            $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
            $valEmailUnico->valEmailUnico($this->Dados['email']);

            $valUsuario = new \App\adms\Models\helper\AdmsValUsuario();
            $valUsuario->valUsuario($this->Dados['usuario']);

            $valSenha = new \App\adms\Models\helper\AdmsValSenha();
            $valSenha->valSenha($this->Dados['senha']);

            if(($valEmail->getResultado()) AND ($valEmailUnico->getResultado() AND ($valUsuario->getResultado()) AND ($valSenha->getResultado()) )){

                // se retorna true email válido e único
                $this->inserir();

            } else {
                $this->Resultado = false;
            }

        }
    }

    private function validarDados()
    {
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if(in_array('', $this->Dados)){
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Necessário preencher todos os campos!</div>';
            $this->Resultado = false;
        } else {

            $this->Resultado = true;

        }

    }

    private function inserir()
    {
        $this->ifoCadUser();
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
        $this->Dados['conf_email'] = md5($this->Dados['senha'] . date('Y-m-d H:i'));
        $this->Dados['adms_niveis_acesso_id'] = $this->IfoCadUser[0]['adms_niveis_acesso_id'];
        $this->Dados['adms_sits_usuario_id'] = $this->IfoCadUser[0]['adms_sits_usuario_id'];
        $this->Dados['created'] = date('Y-m-d H:i:s');
        $this->Dados['adms_empresa_id'] = 1;  // Obs: apenas enquanto em teste, cadastrar todos usuarios sendo da empresa ipac

        $cadUser = new \App\adms\Models\helper\AdmsCreate();
        $cadUser->exeCreate('adms_usuarios', $this->Dados);
        if($cadUser->getResultado()){

            if($this->IfoCadUser[0]['env_email_conf'] == 1) {
                $this->dadosEmail();
            } else {
                $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                $this->Resultado = true;
            }


        }else{
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Usuário não foi cadastrado com sucesso!</div>";
            $this->Resultado = false;
        }
    }

    private function ifoCadUser()
    {
        //Buscando valores atribuidos para os dados fixo no banco de dados
        $infoCadUser = new \App\adms\Models\helper\AdmsRead();
        $infoCadUser->fullRead("SELECT env_email_conf, adms_niveis_acesso_id, adms_sits_usuario_id FROM adms_cads_usuarios WHERE id =:id LIMIT :limit", "id=1&limit=1");
        $this->IfoCadUser = $infoCadUser->getResultado();

    }

    private function dadosEmail()
    {
        $nome = explode(" ", $this->Dados['nome']);
        $prim_nome = $nome[0];

        // Formato com HTML
        $this->DadosEmail['dest_nome'] = $prim_nome;
        $this->DadosEmail['dest_email'] = $this->Dados['email'];
        $this->DadosEmail['titulo_email'] = "Confirmar e-mail";
        $this->DadosEmail['cont_email'] = "Caro(a) $prim_nome, <br><br>";
        $this->DadosEmail['cont_email'] .= "Obrigado por se cadastrar. Para ativar o seu perfil clique no link abaixo:<br><br>";
        $this->DadosEmail['cont_email'] .= "<a href='".URLADM."confirmar/confirmar_email?chave=".$this->Dados['conf_email']."'>Clique aqui</a><br><br>";
        $this->DadosEmail['cont_email'] .= "Obrigado<br>";

        // Formato apenas texto
        $this->DadosEmail['cont_text_email'] = "Caro(a) $prim_nome, ";
        $this->DadosEmail['cont_text_email'] .= "Obrigado por se cadastrar. Para ativar o seu perfil, copie o endereço abaixo e cole no navegador:";
        $this->DadosEmail['cont_text_email'] .= URLADM."confirmar/confirmar_email?chave=".$this->Dados['conf_email'];
        $this->DadosEmail['cont_text_email'] .= "Obrigado";


        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);
        if($emailPHPMailer->getResultado()){

            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso. Enviado no seu e-mail o link para confirmar o e-mail!</div>";
            $this->Resultado = true;

        } else {

            $_SESSION['msg'] = "<div class='alert alert-primary'>Usuário cadastrado com sucesso. Erro não foi possível enviar o link no seu e-mail para confirmar o e-mail!</div>";
            $this->Resultado = false;

        }

    }


}