<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\adms\Models;

use DateTime;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\funcoes\BuscarDuracaoJornadaT;

/**
 * Description of AdmsReordenarData
 *
 * @author joao.victor
 */
class AdmsReordenarData {

    private $FuncionarioId;
    private $dataAtual;
    private $Resultado;
    private $DuracaoTotalAtivi;
    private $Data;
    private $JornadaFunc;
    private $HoraTermino2;
    private $Dados;
    private $TempoExcedido;
    private $horaFimAtvAnt;

    /*
      function getHoraAlmoco() {
      return $this->JornadaFunc['hora_termino'];
      } */

    function getResultado() {
        return $this->Resultado;
    }

    public function defineData($Funcionario = null, $Data = null, $horaFimAtvAnt = null) {
        $this->FuncionarioId = $Funcionario;
        $novaData = $Data;
        $this->horaFimAtvAnt = $horaFimAtvAnt;

        $reordemDia = new \App\adms\Models\AdmsAtendimentoFuncionarios();

        //echo $cont ."\n";
        $reordemDia->atividadeDuracao($this->FuncionarioId, $novaData);
        $this->DuracaoTotalAtivi = $reordemDia->getAtividadeDuracao();

        $reordemDia->buscarJornada($this->FuncionarioId, $novaData);
        $this->JornadaFunc = $reordemDia->getBuscarJornada();

        $reordemDia->buscarUltimaAtividadeDefineData($novaData);
        $this->UltimaAtividadeLoop = $reordemDia->getBuscarUltimaAtividadeDefineData();


        if (($this->JornadaFunc['jornadaFunc'] > $this->DuracaoTotalAtivi[0]['duracao_atividade_sc']) and ( $this->JornadaFunc['hora_termino2'] > $this->horaFimAtvAnt)) {

            $this->Dados['data_inicio_planejado'] = $novaData;
            echo $this->Dados['data_inicio_planejado'];
            //break;
        } else {

            if ($this->JornadaFunc['hora_termino2'] < $this->horaFimAtvAnt) {

                /*
                 * calcular o tempo excedido quando a soma total das atividades não ultrapassa a jornada de trabalho
                 * mas ultrapassa as 18 horas do dia
                 *
                 */

                //Como entra apenas uma vez nessa condição, quando o horário da ultima atividade for maior que a HoraTermino2 o horário da ultima atividade pode ser definido igual a HoraTermino2
                $help = explode(':', $this->JornadaFunc['hora_termino2']);
                $data = new DateTime(date('H:i', strtotime($this->horaFimAtvAnt)));
                $data->modify('-' . $help[0] . ' hours');
                $data->modify('-' . $help[1] . ' minutes');
                $resultado = $data->format('H:i:s');

                $partes = explode(':', $resultado);
                $resultado = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];


                $this->TempoExcedido = $resultado;
                //die;
            } else {
                $this->TempoExcedido = "0";
            }
            $data = new DateTime(date('Y-m-d', strtotime($novaData)));
            $data->modify('+1 day');
            $novaData = $data->format('Y-m-d');
            //echo $novaData;

            $this->Dados['data_inicio_planejado'] = $novaData;
            //$this->horaFimAtvAnt = $this->UltimaAtividadeLoop[0]['hora_fim_planejado']; //Se somar um dia buscará a hora da ultima atividade para esse dia
        }
        var_dump($this->Dados);
    }

    public function getDefineData() {
        $this->Resultado = ['nova_data' => $this->Dados['data_inicio_planejado'], 'tempo_excedido' => $this->TempoExcedido];
        return $this->Resultado;
    }

    public function verificarExisteAtividade($Data = null) {

        $this->Data = $Data; //nova Data definida pelo método acima


        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT id 
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "data_inicio_planejado={$this->Data}&adms_funcionario_id={$this->FuncionarioId}&limit=1");

        if ($dataHora->getResultado()) {
            $this->jaExiste = $dataHora->getResultado();
        }
    }

    public function getVerificarExisteAtividade() {
        return $this->jaExiste;
    }

    public function buscarUltimaAtiviFuncAlmoco($horaFimAtv, $data, $duracao, $tempo_excedido = NULL, $inicio_atv_almoco = NULL) { //Recebe a hora que está terminando sem intervalo de almoço
        $this->Dados['data_inicio_planejado'] = $data;
        $this->Dados['duracao_atividade'] = $duracao;

        $jornadaFunc = new BuscarDuracaoJornadaT($this->FuncionarioId, $this->Dados['data_inicio_planejado']);
        $pausa_almoco = $jornadaFunc->getDuracaoJornada()['hora_termino'];
        $retorna_trabalho = $jornadaFunc->getDuracaoJornada()['hora_inicio2'];
        $start_job = $jornadaFunc->getDuracaoJornada()['hora_inicio'];

        if (empty($pausa_almoco)) {
            return $this->Resultado = false;
        }

        $compara_hora_inicio = $this->horaFimAtvAnt; //Já está no atributo a hora fim da ultima atv e seria a hora de inicio da atv em questão
        
        echo  'Hora inicio atv sem intervalo: ' . $compara_hora_inicio;
        
        if (($compara_hora_inicio < $pausa_almoco) and ($pausa_almoco < $horaFimAtv)) {
            $calculaAlmoco = new Funcoes();
            $totalTimeAlmoco = $calculaAlmoco->sbtrair_horas_in_hours($retorna_trabalho, $pausa_almoco);
            $this->Dados['hora_inicio_planejado'] = $compara_hora_inicio;
            $this->Dados['hora_fim_planejado'] = $calculaAlmoco->somar_time_in_hours($totalTimeAlmoco, $horaFimAtv);
        }
        
        var_dump($this->Dados);
        echo 'Tempo Excedido: ' . $tempo_excedido;
        
        if (($inicio_atv_almoco >= $pausa_almoco) and ($inicio_atv_almoco < $retorna_trabalho)) { //Antes utilizava o compara_hora_inicio
            echo 'Entrou aqui! ';
            /*
             * calcular se o tempo excedido da atividade anterior termina durante o horario de almoço, se sim, somar horario de almoço
             * na hora_inicio_planejado da atividade sendo registrada e somar a duração da atividade definindo a hora_fim_planejado
             */

            $verificarTimeExcedido = new Funcoes();

            $timeExcedido = $verificarTimeExcedido->segundos_to_hora($tempo_excedido);
            
            echo '<br>Time excedido: ' . $timeExcedido;
            
            //die();
            
            $horaInicioSemAlmoco = $verificarTimeExcedido->somar_time_in_hours($timeExcedido, $start_job);

            if ($horaInicioSemAlmoco > $pausa_almoco) {

                $calcularInicioAfterAlmoco = new Funcoes();
                $totalTimeAlmoco = $calcularInicioAfterAlmoco->sbtrair_horas_in_hours($retorna_trabalho, $pausa_almoco);
                $this->Dados['hora_inicio_planejado'] = $calcularInicioAfterAlmoco->somar_time_in_hours($totalTimeAlmoco, $inicio_atv_almoco);
                $this->Dados['hora_fim_planejado'] = $calcularInicioAfterAlmoco->somar_time_in_hours($this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado']);
            } else {
                // Caso a nova atividade a ser registrada inicie durante o almoço, será definida pra ela o novo inicio após o almoço
                $this->Dados['hora_inicio_planejado'] = $retorna_trabalho;
                $calculaAlmoco = new Funcoes();
                $this->Dados['hora_fim_planejado'] = $calculaAlmoco->somar_time_in_hours($this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado']);
            }
        }
    }

    public function getBuscarUltimaAtiviFuncAlmoco() {

        if (!empty($this->Dados['hora_inicio_planejado']) && !empty($this->Dados['hora_fim_planejado'])) {
             $this->Resultado = ["hora_inicio" => $this->Dados['hora_inicio_planejado'], "hora_fim" => $this->Dados['hora_fim_planejado']];
             echo 'hora fim depois do almoço' .  $this->Resultado['hora_fim'];
            return $this->Resultado;
        } else {
            return FALSE;
        }
    }

}
