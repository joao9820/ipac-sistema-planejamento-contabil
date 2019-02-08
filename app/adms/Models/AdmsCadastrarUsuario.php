<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

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
        $verUsuario = new \App\adms\Models\helper\AdmsRead();
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

        $valCampos = new \App\adms\Models\helper\AdmsCampoVazio();
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

        $valEmail = new \App\adms\Models\helper\AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
        $valEmailUnico->valEmailUnico($this->Dados['email']);

        $valUsuarioUnico = new \App\adms\Models\helper\AdmsValUsuario();
        $valUsuarioUnico->valUsuario($this->Dados['usuario']);

        $valSenha = new \App\adms\Models\helper\AdmsValSenha();
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


        $slugImg = new \App\adms\Models\helper\AdmsSlug();
        $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

        //var_dump($this->Dados);

        $cadUsuario = new \App\adms\Models\helper\AdmsCreate();
        $cadUsuario->exeCreate("adms_usuarios", $this->Dados);
        if ($cadUsuario->getResultado())
        {

            if (empty($this->Foto['name'])) {

                $this->ifoCadUser();
                //var_dump($this->IfoCadUser);

                if (($this->Dados['adms_sits_usuario_id'] == 3) AND ($this->IfoCadUser[0]['env_email_conf'] == 1)) {

                    $this->dadosEmail();

                } else {

                    $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                    $this->Resultado = true;

                }


            } else {
                $this->Dados['id'] = $cadUsuario->getResultado();
                $this->valFoto();
            }



        } else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Usuário não foi cadastrado!!</div>";
            $this->Resultado = false;

        }

    }

    private function valFoto()
    {


        $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
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

                $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso!</div>";
                $this->Resultado = true;

            }

        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: O Usuário não foi cadastrado!</div>";
            $this->Resultado = false;
        }


    }

    public function listarCadastrar()
    {
        $listar = new \App\adms\Models\helper\AdmsRead();
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
        $infoCadUser = new \App\adms\Models\helper\AdmsRead();
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


        $emailPHPMailer = new \App\adms\Models\helper\AdmsPhpMailer();
        $emailPHPMailer->emailPhpMailer($this->DadosEmail);
        if($emailPHPMailer->getResultado()){

            $_SESSION['msg'] = "<div class='alert alert-success'>Usuário cadastrado com sucesso. Um e-mail com um link de confirmação foi enviado para o e-mail do usuário!</div>";
            $this->Resultado = true;

        } else {

            $_SESSION['msg'] = "<div class='alert alert-primary'>Usuário cadastrado com sucesso. Erro não foi possível enviar o link no seu e-mail para confirmar o e-mail!</div>";
            $this->Resultado = false;

        }

    }


}