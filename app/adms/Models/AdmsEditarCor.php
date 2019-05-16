<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 13:53
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCampoVazio;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsEditarCor
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verCor($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verCor = new AdmsRead();
        $verCor->fullRead("SELECT * FROM adms_cors
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verCor->getResultado();
        return $this->Resultado;
    }

    public function altCor(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditCor();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditCor()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltCor = new AdmsUpdate();
        $upAltCor->exeUpdate("adms_cors", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltCor->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Cor atualizada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A cor não foi atualizada.","danger");
            $this->Resultado = false;
        }
    }

}