<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:11
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCreate;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;
use DateTime;


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
    private $Dados;
    private $Log;
    private $DadosLog;
    private $ResultadoStsIniciado;
    private $ResultadoTempo;
    private $AtendimentoId;

    public function alterarStatus($DadosId = null, $Status = null, $AtendimentoId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->Status = (int) $Status;
        $this->AtendimentoId = (int) $AtendimentoId;

        $this->verificarAtenIniciado();
        if (isset($this->ResultadoStsIniciado) AND !empty($this->ResultadoStsIniciado))
        {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Você só pode executar um atendimento por vez. Para iniciar um novo, pause ou finalise o atendimento que está em andamento.","warning");
            $this->Resultado = false;
        }
        else {

            if ($this->Status == 1) {
                $statusLog = "Iniciado";
                $this->registLogs($statusLog);
                if ($this->Log) {
                    $this->alterar();
                } else {

                    $alert = new AdmsAlertMensagem();
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível iniciar a atividade.","danger");
                    $this->Resultado = false;
                }

            } elseif ($this->Status == 2) {
                $statusLog = "Pausado";
                $this->registLogs($statusLog);
                if ($this->Log) {
                    $this->alterar();
                } else {
                    $alert = new AdmsAlertMensagem();
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível pausar a atividade.","danger");
                    $this->Resultado = false;
                }
            } elseif ($this->Status == 3) {
                $statusLog = "Iniciado";
                $this->registLogs($statusLog);
                if ($this->Log) {
                    $this->alterar();
                } else {
                    $alert = new AdmsAlertMensagem();
                    $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível iniciar a atividade.","danger");
                    $this->Resultado = false;
                }
            } elseif ($this->Status == 4) {
                $this->alterar();
            } elseif ($this->Status == 5){
                $this->interromperAtendi();
            }
        }

    }

    private function interromperAtendi()
    {
        $this->Dados['adms_sits_atendimentos_funcionario_id'] = 5;
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upInterr = new AdmsUpdate();
        $upInterr->exeUpdate("adms_atendimento_funcionarios", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upInterr->getResultado()) {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade interrompida!","warning");
            $this->Resultado = true;

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível atualizar a atividade.","danger");
            $this->Resultado = false;
        }
    }

    private function buscarTempoRestante()
    {
        $tempoRestante = new AdmsRead();
        $tempoRestante->fullRead("SELECT at_tempo_restante, at_iniciado, at_tempo_excedido FROM adms_atendimento_funcionarios 
                WHERE id=:id AND adms_funcionario_id =:adms_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}");
        $this->ResultadoTempo = $tempoRestante->getResultado();
    }

    private function alterar()
    {
        if ($this->Status == 1) {

            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 2;
            //$this->Dados['adms_sits_atendimento_id'] = 2;
            $this->Dados['inicio_atendimento'] = date("Y-m-d H:i:s");
            $this->Dados['at_iniciado'] = date("Y-m-d H:i:s");
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade iniciada!","primary");
            $this->Dados['at_tempo_excedido'] = null;

        } elseif ($this->Status == 2) {

            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 3;
            $this->Dados['at_pausado'] = date("Y-m-d H:i:s");
            //$this->Dados['adms_sits_atendimento_id'] = 2;

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

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade pausada!","warning");


        } elseif ( $this->Status == 3) {
            $this->Dados['adms_sits_atendimentos_funcionario_id'] = 2;
            $this->Dados['at_iniciado'] = date("Y-m-d H:i:s");
            //$this->Dados['adms_sits_atendimento_id'] = 2;

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade retomada!","info");

        }

        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAtendimento = new AdmsUpdate();
        $upAtendimento->exeUpdate("adms_atendimento_funcionarios", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upAtendimento->getResultado()) {

            if ($this->Status == 1) {
                $this->iniciarAtendimento();
            }

            $this->Resultado = true;

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível atualizar o status!","danger");
            $this->Resultado = false;
        }
    }

    public function verTotalHoras($DadosDemandaId)
    {
        $this->DadosDemandaId = (int) $DadosDemandaId;

        $qtdHoras = new AdmsRead();
        $qtdHoras->fullRead("SELECT time_format( SEC_TO_TIME( SUM( TIME_TO_SEC( duracao ) ) ),'%H:%i:%s') 
                                    AS total_horas FROM adms_atividades where adms_demanda_id=:adms_demanda_id", "adms_demanda_id={$this->DadosDemandaId}");
        $this->Resultado = $qtdHoras->getResultado();
        return $this->Resultado;
    }

    private function registLogs($StatusLog)
    {
        $this->StatusLog = (string) $StatusLog;
        $this->DadosLog['status_log'] = $this->StatusLog;
        $this->DadosLog['adms_atendimento_funcionario_id'] = $this->DadosId;
        $this->DadosLog['created'] = date("Y-m-d H:i:s");
        //echo $this->StatusLog;
        $registrarLog = new AdmsCreate();
        $registrarLog->exeCreate("adms_logs_atendimentos",$this->DadosLog);
        $this->Log = $registrarLog->getResultado();

    }

    private function verificarAtenIniciado()
    {
        $verificarAtenIni = new AdmsRead();
        $verificarAtenIni->fullRead("SELECT id, adms_demanda_id FROM adms_atendimento_funcionarios 
                WHERE id<>:id AND adms_funcionario_id =:adms_funcionario_id AND adms_sits_atendimentos_funcionario_id =:adms_sits_aten_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}&adms_sits_aten_funcionario_id=2");
        $this->ResultadoStsIniciado = $verificarAtenIni->getResultado();
    }


    private function iniciarAtendimento()
    {
        $DadosAten['adms_sits_atendimento_id'] = 2;
        $DadosAten['inicio_atendimento'] = date('Y-m-d H:i:s');
        $DadosAten['modified'] = date('Y-m-d H:i:s');

        $finalizar_aten = new AdmsUpdate();
        $finalizar_aten->exeUpdate("adms_atendimentos", $DadosAten,"WHERE id=:id","id={$this->AtendimentoId}");
        return $finalizar_aten->getResultado();

    }



    public function finalizarAtendimento()
    {
        $this->Dados['adms_sits_atendimentos_funcionario_id'] = 4;
        $this->Dados['fim_atendimento'] = date("Y-m-d H:i:s");


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

//$this->Dados['adms_sits_atendimento_id'] = '3';



        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAtendimento = new AdmsUpdate();
        $upAtendimento->exeUpdate("adms_atendimento_funcionarios", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");

        if ($upAtendimento->getResultado()) {

            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Atividade finalizada!","success");
            $this->Resultado = true;

        } else {
            $alert = new AdmsAlertMensagem();
            $_SESSION['msg'] = $alert->alertMensagemJavaScript("Não foi possível atualizar a atividade.","danger");
            $this->Resultado = false;
        }
    }

}