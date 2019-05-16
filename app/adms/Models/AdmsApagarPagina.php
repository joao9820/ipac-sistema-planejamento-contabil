<?php

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

/**
 * Description of AdmsApagarPagina: 
 * Classe para apagar página do administrativo
 */
class AdmsApagarPagina
{

    private $DadosId;
    private $Resultado;
    private $DadosUpNivAcPg;
    private $DadosNivAcPg;
    private $DadosNivAc;

    /**
     * <b>Obter Resultado:</b> Retorna TRUE caso tenha apagado com sucesso e FALSE quando não conseguiu editar
     * @return bool true ou false
     */
    function getResultado()
    {
        return $this->Resultado;
    }

    /**
     * <b>Ver Página:</b> Receber o id da página para apagar o registro no banco de dados
     * Chamar o método "pesqNivAc" para verificar a permissões com número da ordem maior da qual será apagada
     * @param int $DadosId
     */
    public function apagarPagina($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->pesqNivAc();
        $apagarPagina = new AdmsDelete();
        $apagarPagina->exeDelete("adms_paginas", "WHERE id =:id", "id={$this->DadosId}");
        if ($apagarPagina->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Pagina apagada!","success");
            $this->Resultado = true;
        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Pagina não foi apagada!","danger");
            $this->Resultado = false;
        }
    }

    /**
     * <b>Pesquisar Nível de Acesso:</b> Pesquisar no banco de dados os níveis de acesso
     * @return array $this->DadosNivAc
     */
    private function pesqNivAc()
    {
        $verNivAc = new AdmsRead();
        $verNivAc->fullRead("SELECT id id_nivac FROM adms_niveis_acessos ORDER BY id ASC");
        $this->DadosNivAc = $verNivAc->getResultado();
        $this->pesqNivAcPg();
    }

    /**
     * <b>Pesquisar as Permissões:</b> Pesquisar no banco de dados as permissões dos níveis de acesso na tabela "adms_nivacs_pgs"
     * @return array $this->DadosNivAcPg
     */
    private function pesqNivAcPg()
    {
        if ($this->DadosNivAc) {
            foreach ($this->DadosNivAc as $nivAc) {
                extract($nivAc);
                $verNivAcPg = new AdmsRead();
                /** @var TYPE_NAME $id_nivac */
                $verNivAcPg->fullRead("SELECT id id_nivacpg, ordem FROM adms_nivacs_pgs
                        WHERE adms_niveis_acesso_id =:Aadms_niveis_acesso_id AND 
                        ordem > (SELECT ordem FROM adms_nivacs_pgs WHERE adms_pagina_id =:adms_pagina_id AND adms_niveis_acesso_id =:Badms_niveis_acesso_id) 
                        ORDER BY id ASC", "Aadms_niveis_acesso_id={$id_nivac}&adms_pagina_id={$this->DadosId}&Badms_niveis_acesso_id={$id_nivac}");
                $this->DadosNivAcPg = $verNivAcPg->getResultado();
                $this->updateOrdemNivAcPg();
                $apagarNivAcPg = new AdmsDelete();
                $apagarNivAcPg->exeDelete("adms_nivacs_pgs", "WHERE adms_pagina_id =:adms_pagina_id AND adms_niveis_acesso_id =:adms_niveis_acesso_id", "adms_pagina_id={$this->DadosId}&adms_niveis_acesso_id=$id_nivac");
            }
        }
    }

    /**
     * <b>Alterar Ordem NivAcPg:</b> Alterar as ordem maiores para o nível de acesso na tabela "adms_nivacs_pgs"
     * 
     */
    private function updateOrdemNivAcPg()
    {
        if ($this->DadosNivAcPg) {
            foreach ($this->DadosNivAcPg as $nivAcPg) {
                extract($nivAcPg);
                /** @var TYPE_NAME $ordem */
                $this->DadosUpNivAcPg['ordem'] = $ordem - 1;
                $this->DadosUpNivAcPg['modified'] = date("Y-m-d H:i:s");
                $upAltNivAc = new AdmsUpdate();
                /** @var TYPE_NAME $id_nivacpg */
                $upAltNivAc->exeUpdate("adms_nivacs_pgs", $this->DadosUpNivAcPg, "WHERE id =:id", "id=" . $id_nivacpg);
            }
        }
    }

}
