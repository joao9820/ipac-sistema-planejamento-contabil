<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:11
 */

namespace App\adms\Models;
use \DateTime;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAtendimentoStatus
{
    private $DadosId;
    private $Status;
    private $StatusLog;
    private $Resultado;
    private $DadosDemandaId;
    private $DemandaId;
    private $Dados;
    private $Log;
    private $DadosLog;
    private $ResultadoStsIniciado;
    private $ResultadoDemanda;
    private $ResultadoTempo;

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
            $this->Dados['adms_sits_atendimento_id'] = 2;
            $this->Dados['inicio_atendimento'] = date("Y-m-d H:i:s");
            $this->Dados['at_iniciado'] = date("Y-m-d H:i:s");

            $this->buscarIdDemanda();
            $this->DemandaId = $this->ResultadoDemanda[0]['adms_demanda_id'];
            $this->verTotalHoras($this->DemandaId);
            $this->Dados['duracao_atendimento'] = $this->Resultado[0]['total_horas'];
            $this->Dados['at_tempo_restante'] = $this->Resultado[0]['total_horas'];
            $this->Dados['at_tempo_excedido'] = null;
        }
        elseif ($this->Status == 2) {

            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 3;
            $this->Dados['at_pausado'] = date("Y-m-d H:i:s");

            $this->buscarTempoRestante();
            if (empty($this->ResultadoTempo[0]['at_tempo_excedido'])) {
                // Pegando a hora restante do atendimento no banco e transformando em segundos
                $tempoRestante = $this->ResultadoTempo[0]['at_tempo_restante'];
                $partes = explode(':', $tempoRestante);
                $segundosTotal = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];

                // Pegando a hora do banco em que foi iniciado o atendimento
                $at_iniciado = $this->ResultadoTempo[0]['at_iniciado'];
                $at_pausado = $this->Dados['at_pausado'];
                $dteStart = new DateTime($at_iniciado);
                $dteEnd = new DateTime($at_pausado);
                $dteDiff = $dteStart->diff($dteEnd);
                $horas_diferenca = $dteDiff->format('%H');
                $minutos_diferenca = $dteDiff->format('%i');
                $segundos_diferenca = $dteDiff->format('%s');
                $segundosAndamento = $horas_diferenca * 3600 + $minutos_diferenca * 60 + $segundos_diferenca;

                $segundosDiff = $segundosTotal - $segundosAndamento;
                if ($segundosDiff < 0) {

                    $at_tempo_excedido = $segundosDiff * (-1);
                    $novoTempoExcedido = gmdate("H:i:s", $at_tempo_excedido);
                    $this->Dados['at_tempo_excedido'] = $novoTempoExcedido;
                    $novoTempoRestante = '00:00:00';

                } else {
                    // Transforma segundos para o formato H:i:s 00:00:00
                    $novoTempoRestante = gmdate("H:i:s", $segundosDiff);

                }
                $this->Dados['at_tempo_restante'] = $novoTempoRestante;
            }
            else {

                $tempoRestante = $this->ResultadoTempo[0]['at_tempo_excedido'];
                $partes = explode(':', $tempoRestante);
                $segundosTotal = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];

                // Pegando a hora do banco em que foi iniciado o atendimento
                $at_iniciado = $this->ResultadoTempo[0]['at_iniciado'];
                $at_pausado = $this->Dados['at_pausado'];
                $dteStart = new DateTime($at_iniciado);
                $dteEnd = new DateTime($at_pausado);
                $dteDiff = $dteStart->diff($dteEnd);
                $horas_diferenca = $dteDiff->format('%H');
                $minutos_diferenca = $dteDiff->format('%i');
                $segundos_diferenca = $dteDiff->format('%s');
                $segundosAndamento = $horas_diferenca * 3600 + $minutos_diferenca * 60 + $segundos_diferenca;

                $segundosDiff = $segundosTotal + $segundosAndamento;
                $novoTempoExcedido = gmdate("H:i:s", $segundosDiff);
                $this->Dados['at_tempo_excedido'] = $novoTempoExcedido;

            }
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

    public function verTotalHoras($DadosDemandaId)
    {
        $this->DadosDemandaId = (int) $DadosDemandaId;

        $qtdHoras = new \App\adms\Models\helper\AdmsRead();
        $qtdHoras->fullRead("SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao ) ) ),'%H:%i:%s') 
                                    AS total_horas FROM adms_atividades where adms_demanda_id=:adms_demanda_id", "adms_demanda_id={$this->DadosDemandaId}");
        $this->Resultado = $qtdHoras->getResultado();
        return $this->Resultado;
    }

    private function buscarIdDemanda()
    {
        $verificarAten = new \App\adms\Models\helper\AdmsRead();
        $verificarAten->fullRead("SELECT id, adms_demanda_id FROM adms_atendimentos 
                WHERE id=:id AND adms_funcionario_id =:adms_funcionario_id AND adms_sits_atendimentos_funcionario_id =:adms_sits_aten_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}&adms_sits_aten_funcionario_id=1");
        $this->ResultadoDemanda = $verificarAten->getResultado();
    }

    private function buscarTempoRestante()
    {
        $tempoRestante = new \App\adms\Models\helper\AdmsRead();
        $tempoRestante->fullRead("SELECT at_tempo_restante, at_iniciado, at_tempo_excedido FROM adms_atendimentos 
                WHERE id=:id AND adms_funcionario_id =:adms_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}");
        $this->ResultadoTempo = $tempoRestante->getResultado();
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
        $verificarAtenIni->fullRead("SELECT id, adms_demanda_id FROM adms_atendimentos 
                WHERE id<>:id AND adms_funcionario_id =:adms_funcionario_id AND adms_sits_atendimentos_funcionario_id =:adms_sits_aten_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}&adms_sits_aten_funcionario_id=2");
        $this->ResultadoStsIniciado = $verificarAtenIni->getResultado();
    }

}