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

class AdmsEditarPerfil
{

    private $Resultado;
    private $Dados;
    private $Foto;
    private $ImgAntiga;

    public function getResultado()
    {
        return $this->Resultado;
    }



    public function altPerfil(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem'], $this->Dados['imagem_antiga']);

        $valCampos = new \App\adms\Models\helper\AdmsCampoVazio();
        $valCampos->validarDados($this->Dados);

        if ($valCampos->getResultado()) {
            // se retornar true
            $this->valCampos();

        }
        else {

            $this->Resultado = false;
        }

    }


    private function valCampos()
    {

        $valEmail = new \App\adms\Models\helper\AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $EditarUnico = true;
        $valEmailUnico = new \App\adms\Models\helper\AdmsEmailUnico();
        $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $_SESSION['usuario_id']);

        $valUsuarioUnico = new \App\adms\Models\helper\AdmsValUsuario();
        $valUsuarioUnico->valUsuario($this->Dados['usuario'], $EditarUnico, $_SESSION['usuario_id']);

        if (($valEmail->getResultado()) AND ($valEmailUnico->getResultado()) AND ($valUsuarioUnico->getResultado())){

            //Validar a foto
            $this->valFoto();

        }
        else {

            $this->Resultado = false;

        }

    }


    private function valFoto()
    {

        if (empty($this->Foto['name'])) {

            $this->updateEditPerfil();

        }
        else {

            $slugImg = new \App\adms\Models\helper\AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new \App\adms\Models\helper\AdmsUploadImgRed();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/', $this->Dados['imagem'], 150, 150);
            if ($uploadImg->getResultado())
            {
                // Apagar a imagem antiga se existir
                $apagar = new \App\adms\Models\helper\AdmsApagarImg();
                $apagar->apagarImg('assets/imagens/usuario/'.$_SESSION['usuario_id'].'/'.$this->ImgAntiga);

                $_SESSION['usuario_imagem'] = $this->Dados['imagem'];
                $this->updateEditPerfil();

            }
            else {

                $this->Resultado = false;

            }

        }

    }



    private function updateEditPerfil()
    {
        $this->Dados['modified'] = date('Y-m-d H:i:s');
        $upEditPerfil = new \App\adms\Models\helper\AdmsUpdate();
        //var_dump($this->Dados);
        $upEditPerfil->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$_SESSION['usuario_id']}");
        if ($upEditPerfil->getResultado())
        {

            $_SESSION['usuario_nome'] = $this->Dados['nome'];
            $_SESSION['usuario_email'] = $this->Dados['email'];

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Perfil atualizada com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","O perfil não foi atualizada", "danger");
            $this->Resultado = false;

        }

    }




}