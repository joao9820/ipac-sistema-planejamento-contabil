<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:43
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

class AdmsEditarTipoPg
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verTipoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verTipoPg = new AdmsRead();
        $verTipoPg->fullRead("SELECT * FROM adms_tps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verTipoPg->getResultado();
        return $this->Resultado;
    }

    public function altTipoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditTipoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditTipoPg()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltTipoPg = new AdmsUpdate();
        $upAltTipoPg->exeUpdate("adms_tps_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltTipoPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página atualizado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Tipo de página não foi atualizado.","danger");
            $this->Resultado = false;
        }
    }

}