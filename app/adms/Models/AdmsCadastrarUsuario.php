<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsEmail;
use App\adms\Models\helper\AdmsEmailUnico;
use App\adms\Models\helper\AdmsPhpMailer;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsSlug;
use App\adms\Models\helper\AdmsUploadImgRed;
use App\adms\Models\helper\AdmsValSenha;
use App\adms\Models\helper\AdmsValUsuario;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCadastrarUsuario
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $IfoCadUser;
    private $DadosEmail;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verUsuario($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT * FROM adms_usuarios WHERE id =:id LIMIT :limit",
            "id={$this->DadosId}&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function cadUsuario(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        unset($this->Dados['imagem_nova']);

        $valCampos = new AdmsCampoVazio();
        $valCampos->validarDados($this->Dados);

        if ($valCampos->getResultado()) {
            // se retornar true
            $this->valCampos();

        } else {

            $this->Resultado = false;
        }

    }


    private function valCampos()
    {

        $valEmail = new AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $valEmailUnico = new AdmsEmailUnico();
        $valEmailUnico->valEmailUnico($this->Dados['email']);

        $valUsuarioUnico = new AdmsValUsuario();
        $valUsuarioUnico->valUsuario($this->Dados['usuario']);

        $valSenha = new AdmsValSenha();
        $valSenha->valSenha($this->Dados['senha']);

        if (($valEmail->getResultado()) AND ($valEmailUnico->getResultado()) AND ($valUsuarioUnico->getResultado()) AND ($valSenha->getResultado())){

            //Inserir Usuario
            $this->inserirUsuario();

        } else {
            $this->Resultado = false;
        }
        //$this->updateAltSenha();

    }



    private function inserirUsuario()
    {
        $this->Dados['senha'] = password_hash($this->Dados['senha'], PASSWORD_DEFAULT);
        $this->Dados['created'] = date('Y-m-d H:i:s');
        $this->Dados['adms_empresa_id'] = $_SESSION['adms_empresa_id'];

        if ($this->Dados['adms_sits_usuario_id'] == 3)
        {
            $this->Dados['conf_email'] = md5($this->Dados['senha'] . date('Y-m-d H:i'));
        }


        $slugImg = new AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

        //var_dump($this->Dados);

        $cadUsuario = new AdmsCreate();
        $cadUsuario->exeCreate("adms_usuarios", $this->Dados);
        if ($cadUsuario->getResultado())
        {

            if (empty($this->Foto['name'])) {

                $this->ifoCadUser();
                //var_dump($this->IfoCadUser);

                if (($this->Dados['adms_sits_usuario_id'] == 3) AND ($this->IfoCadUser[0]['env_email_conf'] == 1)) {

                    $this->dadosEmail();

                } else {

                    $alert = new AdmsAlertMensagem();
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário cadastrado!","success");
                    $this->Resultado = true;

                }


            } else {
                $this->Dados['id'] = $cadUsuario->getResultado();
                $this->valFoto();
            }



        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O Usuário não foi cadastrado.","danger");
            $this->Resultado = false;

        }

    }

    private function valFoto()
    {


        $uploadImg = new AdmsUploadImgRed();
        $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/'.$this->Dados['id'].'/', $this->Dados['imagem'], 150, 150);
        if ($uploadImg->getResultado())
        {
            /* Apagar a imagem antiga se existir
            $apagar = new \App\adms\Models\helper\AdmsApagarImg();
            $apagar->apagarImg('assets/imagens/usuario/'.$this->Dados['id'].'/'.$this->ImgAntiga);*/

            $this->ifoCadUser();

            if (($this->Dados['adms_sits_usuario_id'] == 3) AND ($this->IfoCadUser[0]['env_email_conf'] == 1)) {

                $this->dadosEmail();

            } else {

                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário cadastrado.","danger");
                $this->Resultado = true;

            }

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O Usuário não foi cadastrado.","danger");
            $this->Resultado = false;
        }


    }

    public function listarCadastrar()
    {
        $listar = new AdmsRead();
        $listar->fullRead("SELECT id id_nivac, nome nome_nivac FROM adms_niveis_acessos 
                                  WHERE ordem >:ordem ORDER BY nome ASC ", "ordem=".$_SESSION['ordem_nivac']);
        $registro['nivac'] = $listar->getResultado();

        $listar->fullRead("SELECT id id_sit, nome nome_sit FROM adms_sits_usuarios ORDER BY nome ASC ");
        $registro['sit'] = $listar->getResultado();

        $this->Resultado = array('nivac' => $registro['nivac'], 'sit' => $registro['sit']);

        return $this->Resultado;
    }






    private function ifoCadUser()
    {
        //Buscando valores atribuidos para os dados fixo no banco de dados
        $infoCadUser = new AdmsRead();
        $infoCadUser->fullRead("SELECT env_email_conf FROM adms_cads_usuarios WHERE id =:id LIMIT :limit", "id=1&limit=1");
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


        $emailPHPMailer = new AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);
        if($emailPHPMailer->getResultado()){

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário cadastrado! Um e-mail com um link de confirmação foi enviado para o e-mail do usuário.","success");
            $this->Resultado = true;

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário cadastrado! Erro não foi possível enviar o link no seu e-mail para confirmar o e-mail.","info");
            $this->Resultado = false;

        }

    }


}