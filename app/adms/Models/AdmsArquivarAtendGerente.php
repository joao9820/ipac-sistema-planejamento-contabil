<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 05/02/2019
 * Time: 15:09
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsArquivarAtendGerente
{

    private $DadosId;
    private $Dados;
    private $Resultado;

    /**
     * @return mixed
     */
    public function getResultado()
    {
        return $this->Resultado;
    }



    public function arquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado_gerente'] = 1;
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAtendi = new AdmsUpdate();
        $upAtendi->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendi->getResultado()) {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atendimento arquivado!","success");
            $this->Resultado = true;

        }
        else {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível arquivar o atendimento selecionado.","danger");
            $this->Resultado = false;

        }
    }

    public function desarquivar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;

        $this->Dados['arquivado_gerente'] = 2;
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