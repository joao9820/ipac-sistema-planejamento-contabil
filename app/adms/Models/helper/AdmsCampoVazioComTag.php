<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 18/02/2019
 * Time: 09:34
 */

namespace App\adms\Models\helper;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsCampoVazioComTag
{

    private $Dados;
    private $Resultado;

    function getResultado()
    {
        return $this->Resultado;
    }


    public function validarDados(array $Dados)
    {
        $this->Dados = $Dados;
        $this->Dados = array_map('trim', $this->Dados);
        if (in_array('', $this->Dados)) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Necessário preencher todos os campos!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

}