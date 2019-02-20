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

class AdmsFuncConcluirAtendimento
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

    public function alterar($DadosId = null, $Status = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->Status = (int) $Status;

        if ($this->Status == 2){

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

        $this->Dados['adms_sits_atendimentos_funcionario_id'] = 4;
        $this->Dados['fim_atendimento'] = date("Y-m-d H:i:s");
        $this->Dados['modified'] = date("Y-m-d H:i:s");

        $upAtendimento = new \App\adms\Models\helper\AdmsUpdate();
        $upAtendimento->exeUpdate("adms_atendimentos", $this->Dados, "WHERE id =:id", "id={$this->DadosId}");
        if ($upAtendimento->getResultado()){

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Atendimento finalizado com sucesso", "success");
            $this->Resultado = true;

        }
        else {

            $alertMensagem = new \App\adms\Models\helper\AdmsAlertMensagem();
            $_SESSION['msg'] = $alertMensagem->alertMensagemSimples("Desculpe! Erro ao finalizar atendimento.", "danger");
            $this->Resultado = false;

        }


    }

    private function buscarTempoRestante()
    {
        $tempoRestante = new \App\adms\Models\helper\AdmsRead();
        $tempoRestante->fullRead("SELECT at_tempo_restante, at_iniciado, at_tempo_excedido FROM adms_atendimentos 
                WHERE id=:id AND adms_funcionario_id =:adms_funcionario_id", "id={$this->DadosId}&adms_funcionario_id={$_SESSION['usuario_id']}");
        $this->ResultadoTempo = $tempoRestante->getResultado();
    }

}