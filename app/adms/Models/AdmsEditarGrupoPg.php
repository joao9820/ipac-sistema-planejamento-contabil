<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 15:33
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

class AdmsEditarGrupoPg
{

    private $Resultado;
    private $Dados;
    private $DadosId;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function verGrupoPg($DadosId)
    {
        $this->DadosId = (int) $DadosId;
        $verGrupoPg = new AdmsRead();
        $verGrupoPg->fullRead("SELECT * FROM adms_grps_pgs
                WHERE id =:id LIMIT :limit", "id=" . $this->DadosId . "&limit=1");
        $this->Resultado = $verGrupoPg->getResultado();
        return $this->Resultado;
    }

    public function altGrupoPg(array $Dados)
    {
        $this->Dados = $Dados;

        $valCampoVazio = new AdmsCampoVazio;
        $valCampoVazio->validarDados($this->Dados);

        if ($valCampoVazio->getResultado()) {
            $this->updateEditGrupoPg();
        } else {
            $this->Resultado = false;
        }
    }

    private function updateEditGrupoPg()
    {
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upAltGrupoPg = new AdmsUpdate();
        $upAltGrupoPg->exeUpdate("adms_grps_pgs", $this->Dados, "WHERE id =:id", "id=" . $this->Dados['id']);
        if ($upAltGrupoPg->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página atualizado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Grupo de página não foi atualizado.","danger");
            $this->Resultado = false;
        }
    }

}