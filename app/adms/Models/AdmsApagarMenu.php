<?php
/**
 * Created by PhpStorm.
 * User: DHEMES
 * Date: 03/02/2019
 * Time: 01:23
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsApagarMenu
{

    private $DadosId;
    private $Resultado;
    private $Dados;
    private $DadosMenuInferior;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function apagarMenu($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->verfPgCad();
        if ($this->Resultado) {
            $this->verfMenuInferior();
            $apagarMenu = new AdmsDelete();
            $apagarMenu->exeDelete("adms_menus", "WHERE id =:id", "id={$this->DadosId}");
            if ($apagarMenu->getResultado()) {
                $this->atualizarOrdem();
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu apagado!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Item de menu não foi apagado!","danger");
                $this->Resultado = false;
            }
        }
    }

    private function verfPgCad()
    {
        $verMenu = new AdmsRead();
        $verMenu->fullRead("SELECT id FROM adms_nivacs_pgs
                WHERE adms_menu_id =:adms_menu_id LIMIT :limit", "adms_menu_id=" . $this->DadosId . "&limit=2");
        if ($verMenu->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("O item de menu não pode ser apagado, há permissões cadastradas neste item de menu!","danger");
            $this->Resultado = false;
        } else {
            $this->Resultado = true;
        }
    }

    private function verfMenuInferior()
    {
        $verMenu = new AdmsRead();
        $verMenu->fullRead("SELECT id, ordem AS ordem_result FROM adms_menus WHERE ordem > (SELECT ordem FROM adms_menus WHERE id =:id) ORDER BY ordem ASC", "id={$this->DadosId}");
        $this->DadosMenuInferior = $verMenu->getResultado();
    }

    private function atualizarOrdem()
    {
        if ($this->DadosMenuInferior) {
            foreach ($this->DadosMenuInferior as $atualOrdem) {
                extract($atualOrdem);
                /** @var TYPE_NAME $ordem_result */
                $this->Dados['ordem'] = $ordem_result - 1;
                $this->Dados['modified'] = date("Y-m-d H:i:s");
                $upAltMenu = new AdmsUpdate();
                /** @var TYPE_NAME $id */
                $upAltMenu->exeUpdate("adms_menus", $this->Dados, "WHERE id =:id", "id=" . $id);
            }
        }
    }

}