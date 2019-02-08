<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/01/2019
 * Time: 14:08
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsValUsuario
{

    private $Usuario;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;


    function getResultado()
    {
        return $this->Resultado;
    }

    public function valUsuario($Usuario, $EditarUnico = null, $DadoId = null)
    {
        $this->Usuario = $Usuario;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;
        //Consultar se email já cadastrado no banco
        $valUsuario = new \App\adms\Models\helper\AdmsRead();
        if (!empty($this->EditarUnico) AND ($this->EditarUnico == true)) {

            $valUsuario->fullRead("SELECT id FROM adms_usuarios WHERE usuario =:usuario AND id <>:id LIMIT :limit", "usuario={$this->Usuario}&limit=1&id={$this->DadoId}");

        } else  {

            $valUsuario->fullRead("SELECT id FROM adms_usuarios WHERE usuario =:usuario LIMIT :limit", "usuario={$this->Usuario}&limit=1");

        }

        $this->Resultado = $valUsuario->getResultado();
        if(!empty($this->Resultado)){
            //Se o $this->Resultado diferente de vazio significa que encontrou dados
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: Este usuário já está cadastrado!</div>';
            $this->Resultado = false;

        } else {
            $this->valCarctUsuario();
        }
    }

    private function valCarctUsuario()
    {
        if(stristr($this->Usuario, "'")){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado no usuário inválido</div>";
            $this->Resultado = false;
        } else {

            if(stristr($this->Usuario, " ")){
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco no usuário!</div>";
                $this->Resultado = false;
            } else {
                $this->valExtensUsuario();
            }

        }
    }

    private function valExtensUsuario()
    {
        //Verificar se o nome de usuario tem menos de 5 caracteres
        if(strlen($this->Usuario) < 5){
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: O usuário deve ter no mínimo 5 caracteres</div>';
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}