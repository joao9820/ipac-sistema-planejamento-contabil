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
   
   function getResultado() {
       return $this->Resultado;
   }

       
    public function defineData($Funcionario = null, $Data = null, $horaFimAtvAnt= null)
    {      
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
     
            
            if (($this->JornadaFunc['jornadaFunc'] > $this->DuracaoTotalAtivi[0]['duracao_atividade_sc']) and ($this->JornadaFunc['hora_termino2'] > $this->horaFimAtvAnt)) {

                $this->Dados['data_inicio_planejado'] = $novaData;
                echo $this->Dados['data_inicio_planejado'];
                //break;

            } else {

                if ($this->JornadaFunc['hora_termino2'] < $this->horaFimAtvAnt){

                    /*
                     * ATENÇÃO PAREI AQUI
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
    
    public function getDefineData(){
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
    
    public function getVerificarExisteAtividade(){
        return $this->jaExiste;
    }
    
    public function buscarUltimaAtiviFunc() {
        
        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT hora_fim_planejado, hora_inicio_planejado
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id 
        ORDER BY data_inicio_planejado DESC, hora_inicio_planejado DESC LIMIT :limit", "data_inicio_planejado={$this->Data}&adms_funcionario_id={$this->FuncionarioId}&limit=1");
        if ($dataHora->getResultado()) {

            $compara_hora_fim = $dataHora->getResultado()[0]['hora_fim_planejado'];
            $compara_hora_inicio = $dataHora->getResultado()[0]['hora_inicio_planejado'];

            if (($compara_hora_inicio < $this->JornadaFunc['hora_termino']) and ($compara_hora_fim > $this->JornadaFunc['hora_termino'])) {
                /*
                 * Aqui vai somar a $Duracao_almoco com $this->UltimaAtividadeLoop[0]['hora_fim_planejado']
                 *
                 * Atenção, quase pronto, mas falta testar. ta dando erro
                 */
                $this->UltimaAtividade = $dataHora->getResultado();

                $diferencaHoras = new Funcoes();
                $Duracao_almoco = $diferencaHoras->sbtrair_horas_in_hours($this->JornadaFunc['hora_inicio2'], $this->JornadaFunc['hora_termino']);

                //echo $Duracao_almoco;
                $this->UltimaAtividade[0]['hora_fim_planejado'] = $diferencaHoras->somar_time_in_hours($Duracao_almoco, $this->UltimaAtividade[0]['hora_fim_planejado']);

            } else {
                $this->UltimaAtividade = $dataHora->getResultado();
            }
            /*
            var_dump($this->UltimaAtividade);
            echo $this->UltimaAtividade[0]['hora_fim_planejado'];
            die;
            */
        }
    }  
    public function getBuscarUltimaAtiviFunc(){
        return $this->UltimaAtividade;
    }
}
