<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 02/04/2019
 * Time: 17:04
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsPlanejamento
{

    private $Resultado;
    private $Dados;
    private $DadosId;
    private $idPlan;

    function getResultado()
    {
        return $this->Resultado;
    }

    public function atualizarPlanejamento($Dados = null)
    {

        $this->Dados = $Dados;

        $this->verificarIssetPlan();

        $this->DadosId = $this->Dados['adms_funcionario_id'];

        unset($this->Dados['adms_funcionario_id']);


        $this->Dados['modified'] = date('Y-m-d H:i:s');

        $this->verificarCampoVazio();

        $upPlanejamento = new AdmsUpdate();
        $upPlanejamento->exeUpdate("adms_planejamento", $this->Dados, "WHERE id =:id", "id=".$this->idPlan[0]['id']);
        if ($upPlanejamento->getResultado()) {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Planejamento atualizado!","success");
            $this->Resultado = true;

        } else {

            $this->Resultado = false;

        }


    }

    public function registrarPlanejamento($Dados = null)
    {
        $this->Dados = $Dados;

        $this->Dados['created'] = date('Y-m-d H:i:s');

        $this->verificarIssetPlan();

        if (isset($this->idPlan[0]['id'])) {
            // Atualizar
            $this->atualizarPlanejamento($this->Dados);

        } else {
            // Registrar
            $regist = new AdmsCreate();
            $regist->exeCreate("adms_planejamento", $this->Dados);
            if ($regist->getResultado()) {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("Planejamento registrado!","success");
                $this->Resultado = true;
            } else {
                $alert = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alert->alertMensagemJavaScript("O planejamento não foi registrado.","danger");
                $this->Resultado = true;
            }
        }


    }

    private function verificarIssetPlan()
    {
        $verPl = new AdmsRead();
        $verPl->fullRead("SELECT id
                              FROM adms_planejamento WHERE adms_funcionario_id=:adms_funcionario_id LIMIT :limit","adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");
        $this->idPlan = $verPl->getResultado();
    }

    private function verificarCampoVazio()
    {
        if (empty($this->Dados['hora_inicio'])){
            unset($this->Dados['hora_inicio']);
        }
        if (empty($this->Dados['hora_termino'])){
            unset($this->Dados['hora_termino']);
        }
        if (empty($this->Dados['hora_inicio2'])){
            unset($this->Dados['hora_inicio2']);
        }
        if (empty($this->Dados['hora_termino2'])){
            unset($this->Dados['hora_termino2']);
        }
    }


    public function verPlanejamento()
    {
        $verPl = new AdmsRead();
        $verPl->fullRead("SELECT hora_inicio, hora_termino, hora_inicio2, hora_termino2, adms_funcionario_id
                              FROM adms_planejamento WHERE adms_funcionario_id=:adms_funcionario_id LIMIT :limit","adms_funcionario_id={$_SESSION['usuario_id']}&limit=1");
        $this->Resultado = $verPl->getResultado();
        if ($this->Resultado) {
            return $this->Resultado[0];
        } else {
            return $this->Resultado[0] = "";
        }
    }

}