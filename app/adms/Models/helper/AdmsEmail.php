<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/01/2019
 * Time: 13:13
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEmail
{

    private $Resultado;
    private $Dados;
    private $Formato;

    /*
     * Para retornar o resultado que está na $this->Resultado preciso
     * usar o get
     */
    function getResultado()
    {
        return $this->Resultado;
    }

    public function valEmail($Email)
    {
        $this->Dados = (string) $Email;
        $this->Formato = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

        if(preg_match($this->Formato, $this->Dados))
        {
            $this->Resultado = true;
        } else {

            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: E-mail inválido!</div>";
            $this->Resultado = false;
        }
    }

}