<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 04/02/2019
 * Time: 12:55
 */

namespace App\adms\Models;

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

        $upAtendi = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atendimento desarquivado com sucesso", "info");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","Não foi possível desarquivar o atendimento selecionado", "danger");
            $this->Resultado = false;

        }
    }

}