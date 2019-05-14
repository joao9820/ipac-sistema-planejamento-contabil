<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 01/02/2019
 * Time: 22:21
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAltOrdemMenu
{
    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAcPg;
    private $DadosNivAvPgInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function altOrdemMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verNivAcPg();
        if ($this->DadosNivAcPg) {
            $this->verfNivAcPgInferior();
            $this->exeAltOrdemNivAc();
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do menu!","danger");
            $this->Resultado = false;
        }
    }

    private function verNivAcPg()
    {
        $verNivAcPg = new AdmsRead();
        $verNivAcPg->fullRead("SELECT nivpg.id, nivpg.ordem, nivpg.adms_niveis_acesso_id
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivpg.adms_niveis_acesso_id
                WHERE nivpg.id =:id AND nivac.ordem >=:ordem", "id={$this->DadosId}&ordem=" . $_SESSION['ordem_nivac']);
        $this->DadosNivAcPg = $verNivAcPg->getResultado();
    }

    private function verfNivAcPgInferior()
    {
        $ordem_super = $this->DadosNivAcPg[0]['ordem'] - 1;
        $verNivAcPg = new AdmsRead();
        $verNivAcPg->fullRead("SELECT nivpg.id, nivpg.ordem, nivpg.adms_niveis_acesso_id
                FROM adms_nivacs_pgs nivpg
                WHERE nivpg.ordem =:ordem AND nivpg.adms_niveis_acesso_id =:adms_niveis_acesso_id", "ordem=" . $ordem_super . "&adms_niveis_acesso_id={$this->DadosNivAcPg[0]['adms_niveis_acesso_id']}");
        $this->DadosNivAvPgInferior = $verNivAcPg->getResultado();
    }

    private function exeAltOrdemNivAc()
    {
        $this->Dados['ordem'] = $this->DadosNivAcPg[0]['ordem'];
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upMvBaixo = new AdmsUpdate();
        $upMvBaixo->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosNivAvPgInferior[0]['id']}");

        $this->Dados['ordem'] = $this->DadosNivAcPg[0]['ordem'] - 1;
        $upMvCima = new AdmsUpdate();
        $upMvCima->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosNivAcPg[0]['id']}");

        if ($upMvCima->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Ordem do menu editado!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a ordem do menu!","danger");
            $this->Resultado = false;
        }
    }

}