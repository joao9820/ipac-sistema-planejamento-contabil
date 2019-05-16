<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 16:41
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

class AdmsEditarSitPg
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verSitPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verSitPg = new AdmsRead();
        $verSitPg->fullRead("SELECT * FROM adms_sits_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verSitPg->getResultado();
        return $this->Resultado;
    }

    public function altSitPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditSitPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditSitPg()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltSitPg = new AdmsUpdate();
        $upAltSitPg->exeUpdate("adms_sits_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltSitPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Situação de página atualizada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("A situação de página não foi atualizada.","danger");
            $this->Resultado = false;
        }
    }

}