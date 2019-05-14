<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/01/2019
 * Time: 13:56
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEmailUnico
{

    private $Email;
    private $Resultado;
    private $EditarUnico;
    private $DadoId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function valEmailUnico($Email, $EditarUnico = null, $DadoId = null)
    {
        $this->Email = $Email;
        $this->EditarUnico = $EditarUnico;
        $this->DadoId = $DadoId;
        //Consultar se email já cadastrado no banco
        $valEmailUnico = new AdmsRead();
        if (!empty($this->EditarUnico) AND ($this->EditarUnico == true)) {

            $valEmailUnico->fullRead("SELECT id FROM adms_usuarios WHERE email =:email AND id <>:id LIMIT :limit", "email={$this->Email}&limit=1&id={$this->DadoId}");

        } else  {

            $valEmailUnico->fullRead("SELECT id FROM adms_usuarios WHERE email =:email LIMIT :limit", "email={$this->Email}&limit=1");

        }

        $this->Resultado = $valEmailUnico->getResultado();
        if(!empty($this->Resultado)){
            //Se o $this->Resultado diferente de vazio significa que encontrou dados
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Este e-mail já está cadastrado!","danger");
            $this->Resultado = false;

        } else {

            $this->Resultado = true;
        }
    }

}