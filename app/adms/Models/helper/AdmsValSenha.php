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


class AdmsValSenha
{

    private $Senha;
    private $Resultado;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valSenha($Senha)
    {
        $this->Senha = $Senha;

        if(stristr($this->Senha, "'")){
            $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Caracter ( ' ) utilizado na senha inválido</div>";
            $this->Resultado = false;
        } else {

            if(stristr($this->Senha, " ")){
                $_SESSION['msg'] = "<div class='alert alert-danger' role='alert'>Erro: Proibido utilizar espaço em branco na senha!</div>";
                $this->Resultado = false;
            } else {
                $this->valExtensSenha();
            }

        }
    }


    private function valExtensSenha()
    {
        //Verificar se a senha tem menos de 6 caracteres
        if(strlen($this->Senha) < 6){
            $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Erro: A senha deve ter no mínimo 6 caracteres</div>';
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}