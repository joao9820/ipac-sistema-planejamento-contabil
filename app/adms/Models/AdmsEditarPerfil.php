<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:34
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsApagarImg;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsEmail;
use App\adms\Models\helper\AdmsEmailUnico;
use App\adms\Models\helper\AdmsSlug;
use App\adms\Models\helper\AdmsUpdate;
use App\adms\Models\helper\AdmsUploadImg;
use App\adms\Models\helper\AdmsUploadImgRed;
use App\adms\Models\helper\AdmsValUsuario;

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

        $valCampos = new AdmsCampoVazio();
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

        $valEmail = new AdmsEmail();
        $valEmail->valEmail($this->Dados['email']);

        $EditarUnico = true;
        $valEmailUnico = new AdmsEmailUnico();
        $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $_SESSION['usuario_id']);

        $valUsuarioUnico = new AdmsValUsuario();
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

            $slugImg = new AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new AdmsUploadImg();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/'.$_SESSION['usuario_id'].'/', $this->Dados['imagem']);
            if ($uploadImg->getResultado())
            {
                // Apagar a imagem antiga se existir
                $apagar = new AdmsApagarImg();
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
        $upEditPerfil = new AdmsUpdate();
        //var_dump($this->Dados);
        $upEditPerfil->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$_SESSION['usuario_id']}");
        if ($upEditPerfil->getResultado())
        {

            $_SESSION['usuario_nome'] = $this->Dados['nome'];
            $_SESSION['usuario_email'] = $this->Dados['email'];

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Perfil atualizado!","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O perfil não foi atualizado.","danger");
            $this->Resultado = false;

        }

    }




}