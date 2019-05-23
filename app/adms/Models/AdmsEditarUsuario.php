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
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsSlug;
use App\adms\Models\helper\AdmsUpdate;
use App\adms\Models\helper\AdmsUploadImg;
use App\adms\Models\helper\AdmsUploadImgRed;
use App\adms\Models\helper\AdmsValUsuario;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarUsuario
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $Foto;
    private $ImgAntiga;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function verUsuario($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verUsuario = new AdmsRead();
        $verUsuario->fullRead("SELECT user.* 
                        FROM adms_usuarios user  
                        INNER JOIN adms_niveis_acessos nivel_aces ON nivel_aces.id=user.adms_niveis_acesso_id 
                        WHERE user.id =:id AND nivel_aces.ordem >:ordem LIMIT :limit",
            "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']."&limit=1");
        $this->Resultado = $verUsuario->getResultado();
        return $this->Resultado;
    }

    public function altUsuario(array $Dados)
    {
        $this->Dados = $Dados;
        //var_dump($this->Dados);
        $this->Foto = $this->Dados['imagem_nova'];
        $this->ImgAntiga = $this->Dados['imagem_antiga'];
        unset($this->Dados['imagem_nova'], $this->Dados['imagem_antiga']);

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

        $EditarUnico = true;
        $valEmailUnico = new AdmsEmailUnico();
        $valEmailUnico->valEmailUnico($this->Dados['email'], $EditarUnico, $this->Dados['id']);

        $valUsuarioUnico = new AdmsValUsuario();
        $valUsuarioUnico->valUsuario($this->Dados['usuario'], $EditarUnico, $this->Dados['id']);

        if (($valEmail->getResultado()) AND ($valEmailUnico->getResultado()) AND ($valUsuarioUnico->getResultado())){

            //Validar a foto
            $this->valFoto();

        } else {
            $this->Resultado = false;
        }
        //$this->updateAltSenha();

    }


    private function valFoto()
    {

        if (empty($this->Foto['name'])) {

            $this->updateEditUsuario();

        } else {

            $slugImg = new AdmsSlug();
            $this->Dados['imagem'] = $slugImg->nomeSlug($this->Foto['name']);

            $uploadImg = new AdmsUploadImg();
            $uploadImg->uploadImagem($this->Foto, 'assets/imagens/usuario/'.$this->Dados['id'].'/', $this->Dados['imagem']);
            if ($uploadImg->getResultado())
            {
                // Apagar a imagem antiga se existir
                $apagar = new AdmsApagarImg();
                $apagar->apagarImg('assets/imagens/usuario/'.$this->Dados['id'].'/'.$this->ImgAntiga);

                $this->updateEditUsuario();

            } else {
                $this->Resultado = false;
            }

        }

    }


    private function updateEditUsuario()
    {
        $this->Dados['modified'] = date('Y-m-d H:i:s');


        $upEditPerfil = new AdmsUpdate();
        //var_dump($this->Dados);
        $upEditPerfil->exeUpdate("adms_usuarios", $this->Dados, "WHERE id =:id", "id={$this->Dados['id']}");
        if ($upEditPerfil->getResultado())
        {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Usuário atualizado!","success");
            $this->Resultado = true;

        } else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O Usuário não foi atualizado.","danger");
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




}