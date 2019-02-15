<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:11
 */

namespace App\adms\Models;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAtendimentoStatus
{
    private $DadosId;
    private $Status;
    private $StatusLog;
    private $Dados;
    private $Log;
    private $DadosLog;
    private $ResultadoStsIniciado;

    public function alterarStatus($DadosId = null, $Status = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->Status = (int) $Status;

        $this->verificarAtenIniciado();
        if (isset($this->ResultadoStsIniciado) AND !empty($this->ResultadoStsIniciado))
        {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Já existe um atendimento em andamento. Para iniciar um novo, pause ou finalise o atendimento iniciado</div>";
            $this->Resultado = false;
        } else {

            if ($this->Status == 1) {
                $statusLog = "Iniciado";
                $this->registLogs($statusLog);
                if ($this->Log) {
                    $this->alterar();
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível iniciar o atendimento!</div>";
                    $this->Resultado = false;
                }

            } elseif ($this->Status == 2) {
                $statusLog = "Pausado";
                $this->registLogs($statusLog);
                if ($this->Log) {
                    $this->alterar();
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível pausar o atendimento!</div>";
                    $this->Resultado = false;
                }
            } elseif ($this->Status == 3) {
                $statusLog = "Iniciado";
                $this->registLogs($statusLog);
                if ($this->Log) {
                    $this->alterar();
                } else {
                    $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível iniciar o atendimento!</div>";
                    $this->Resultado = false;
                }
            }
        }

    }

    private function alterar()
    {
        if ($this->Status == 1) {
            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 2;
            $this->Dados['inicio_atendimento'] = date("Y-m-d H:i:s");
            $this->Dados['at_iniciado'] = date("Y-m-d H:i:s");
        }
        elseif ($this->Status == 2) {
            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 3;
            $this->Dados['at_pausado'] = date("Y-m-d H:i:s");
        }
        elseif ( $this->Status == 3) {
            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 2;
            $this->Dados['at_iniciado'] = date("Y-m-d H:i:s");
        }
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAtendimento = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendimento->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upAtendimento->getResultado()) {
            $_SESSION['msg'] = "<div class='alert alert-success'>Atendimento atualizado com sucesso!</div>";
            $this->Resultado = true;
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>Erro: Não foi possível atualizar o atendimento!</div>";
            $this->Resultado = false;
        }
    }

    private function registLogs($StatusLog)
    {
        $this->StatusLog = (string) $StatusLog;
        $this->DadosLog['status_log'] = $this->StatusLog;
        $this->DadosLog['adms_atendimento_id'] = $this->DadosId;
        $this->DadosLog['created'] = date("Y-m-d H:i:s");
        //echo $this->StatusLog;
        $registrarLog = new \App\adms\Models\helper\AdmsCreate();
        $registrarLog->exeCreate("adms_logs_atendimentos",$this->DadosLog);
        $this->Log = $registrarLog->getResultado();

    }

    private function verificarAtenIniciado()
    {
        $verificarAtenIni = new \App\adms\Models\helper\AdmsRead();
        $verificarAtenIni->fullRead("SELECT id FROM adms_atendimentos 
                WHERE id<>:id AND adms_funcionario_id =:adms_funcionario_id AND adms_sits_atendimentos_funcionario_id =:adms_sits_aten_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}&adms_sits_aten_funcionario_id=2");
        $this->ResultadoStsIniciado = $verificarAtenIni->getResultado();
    }

}