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

class AdmsCancelarAtendimento
{
    private $DadosId;
    private $Dados;
    private $Resultado;

    public function cancelar($DadosId = null)
    {

        $this->DadosId = (int) $DadosId;
        $this->Dados['cancelado_p_user'] = 1;
        $this->Dados['adms_sits_atendimento_id'] = 4;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAtendi = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atendimento cancelado com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","Não foi possível cancelar o atendimento selecionado", "danger");
            $this->Resultado = false;

        }

    }

}