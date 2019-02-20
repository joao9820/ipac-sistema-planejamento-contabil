<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 05/02/2019
 * Time: 15:09
 */

namespace App\adms\Models;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsArquivarAtendGerente
{

    private $DadosId;
    private $Dados;

    public function arquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado_gerente'] = 1;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAtendi = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atendimento arquivado com sucesso", "info");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagem("Desculpe! Ocorreu um erro.","Não foi possível arquivar o atendimento selecionado", "danger");
            $this->Resultado = false;

        }
    }

    public function desarquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado_gerente'] = 2;
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