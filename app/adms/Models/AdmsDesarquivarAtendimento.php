<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/02/2019
 * Time: 12:55
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsDesarquivarAtendimento
{
    private $DadosId;
    private $Dados;
    private $Resultado;

    public function desarquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado'] = 2;
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAtendi = new AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atendimento desarquivado!","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível desarquivar o atendimento selecionado.","danger");
            $this->Resultado = false;

        }
    }

}