<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 24/01/2019
 * Time: 15:37
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsCampoVazio
{
    // Valida se o campo está vazio

    private $Dados;
    private $Resultado;

    public function getResultado()
    {
        return $this->Resultado;
    }

    public function validarDados(array $Dados)
    {
        $this->Dados = $Dados;
        $this->Dados = array_map('strip_tags', $this->Dados);
        $this->Dados = array_map('trim', $this->Dados);
        if(in_array('', $this->Dados)){
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário preencher todos os campos!","danger");
            $this->Resultado = false;
        } else {

            $this->Resultado = true;

        }

    }

}