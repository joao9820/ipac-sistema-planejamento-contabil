<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsLibPermi
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosNivAcPg;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function libPermi($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verNivAcPg();
        if ($this->DadosNivAcPg) {
            $this->altPermi();
        }else{
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a permissão de acesso a página.","danger");
            $this->Resultado = false;
        }
    }

    private function verNivAcPg()
    {
        $verNivAcPg = new AdmsRead();
        $verNivAcPg->fullRead("SELECT nivpg.id, nivpg.permissao 
                FROM adms_nivacs_pgs nivpg
                INNER JOIN adms_niveis_acessos nivac ON nivac.id=nivpg.adms_niveis_acesso_id
                WHERE nivpg.id =:id AND nivac.ordem >:ordem", "id={$this->DadosId}&ordem=".$_SESSION['ordem_nivac']);        
        $this->DadosNivAcPg = $verNivAcPg->getResultado();
    }

    private function altPermi()
    {
        if ($this->DadosNivAcPg[0]['permissao'] == 1) {
            $this->Dados['permissao'] = 2;
        } else {
            $this->Dados['permissao'] = 1;
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");
        $upPerm = new AdmsUpdate();
        $upPerm->exeUpdate("adms_nivacs_pgs", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upPerm->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Alterado a permissão de acesso a página!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi alterado a permissão de acesso a página!","danger");
            $this->Resultado = false;
        }
    }

}
