<?php

/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 08/04/2019
 * Time: 15:59
 */

namespace App\adms\Models;

use App\adms\Models\funcoes\BuscarDuracaoJornadaT;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\funcoes\VerificarDataDisponivel;
use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\helper\AdmsCreateRow;
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use DateTime;
use App\adms\Models\AdmsVerificarDataFatal;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAtendimentoFuncionarios {

    private $Dados;
    private $Resultado;
    private $DemandaId;
    private $DadosAtivi;
    private $Atendimento;
    private $AtenId;
    private $FuncId;
    private $AtivId;
    private $jaExiste;
    private $jaExisteAtv;
    private $Data;
    private $FuncionarioId;
    private $HoraExtra;
    private $horaInicioFunc;
    private $UltimaAtividade;
    private $DataAtual;
    private $JornadaFunc;
    private $DuracaoTotalAtivi;
    private $TempoExcedido;
    private $HoraTermino2;
    private $DataLoop;
    private $UltimaAtividadeLoop;
    private $HoraInicio2;
    private $horaInicio1;
    private $HoraTermino;

    /**
     * @return mixed
     */
    public function getResultado() {
        return $this->Resultado;
    }

    public function listarFuncionarios() {
        $funfionarios = new AdmsRead();
        $funfionarios->fullRead("SELECT id, nome FROM adms_usuarios
                                        WHERE adms_niveis_acesso_id=:adms_niveis_acesso_id
                                        AND adms_empresa_id=:adms_empresa_id
                                        AND adms_sits_usuario_id=:adms_sits_usuario_id
                                        AND adms_departamento_id<>:adms_departamento_id
                                        AND id IN (SELECT adms_funcionario_id FROM adms_planejamento)
                                        ORDER BY nome ASC", "adms_niveis_acesso_id=4&adms_empresa_id=1&adms_sits_usuario_id=1&adms_departamento_id=NULL");
        $this->Resultado = $funfionarios->getResultado();
    }

    public function listarAtividadesDemanda($DemandaId = null, $AtendId = null) {
        $this->AtivId = (int) $AtendId;
        $this->DemandaId = (int) $DemandaId;
        $atividades = new AdmsRead();
        $atividades->fullRead("SELECT id, nome
                                        FROM adms_atividades
                                        WHERE adms_demanda_id=:adms_demanda_id
                                        AND id NOT IN (SELECT adms_atividade_id FROM adms_atendimento_funcionarios WHERE adms_atendimento_id = {$AtendId})", "adms_demanda_id={$this->DemandaId}");
        $this->Resultado = $atividades->getResultado();
    }

    public function listar($Atendimento = null) {
        $this->Atendimento = (int) $Atendimento;
        $listar = new AdmsRead();
        $listar->fullRead("SELECT aten_fun.id id_aten_fun,aten_fun.duracao_atividade, aten_fun.data_fatal, aten_fun.hora_fatal, aten_fun.ordem_atividade, aten_fun.adms_sits_atendimentos_funcionario_id sit_func,
                                    aten_fun.adms_atendimento_id aten_id, aten_fun.adms_funcionario_id func_id, aten_fun.adms_atividade_id ativ_id, aten_fun.adms_demanda_id dema_id,aten_fun.inicio_atendimento, aten_fun.fim_atendimento,
                                    aten_fun.data_inicio_planejado, aten_fun.hora_inicio_planejado,
                                    sits_func.nome status, 
                                    funcionario.nome, 
                                    depart.nome departamento,
                                    ativi.nome atividade,
                                    cr.cor,
                                    planejar.jornada_trabalho
                                    FROM adms_atendimento_funcionarios aten_fun
                                    INNER JOIN adms_usuarios funcionario  ON funcionario.id = aten_fun.adms_funcionario_id
                                    INNER JOIN adms_departamentos depart ON depart.id = funcionario.adms_departamento_id
                                    INNER JOIN adms_atividades ativi ON ativi.id = aten_fun.adms_atividade_id
                                    INNER JOIN adms_sits_atendimentos_funcionario sits_func ON sits_func.id = aten_fun.adms_sits_atendimentos_funcionario_id
                                    INNER JOIN adms_cors cr ON cr.id = sits_func.adms_cor_id
                                    INNER JOIN adms_planejamento planejar ON planejar.adms_funcionario_id = aten_fun.adms_funcionario_id
                                    WHERE aten_fun.adms_atendimento_id=:adms_atendimento_id
                                    ORDER BY funcionario.nome ASC", "adms_atendimento_id={$this->Atendimento}");
        $this->Resultado = $listar->getResultado();
        return $this->Resultado;
    }

    public function registrar($Dados = null) {
        $this->Dados = $Dados;

        /*
         * Chamando class para verificar se a data fatal pode ser definida para o dia escolhido
         * Caso a data fatal não possa ser definida para a data escolhida pelo fato do funcionário
         * já ter muitas atividades e não conseguir realizar mais uma até essa data especifica.
         */
        /*
          do {
          $DataFatalP = new AdmsVerificarDataFatal($this->Dados['adms_funcionario_id'], $this->Dados['data_fatal'], $this->Dados['adms_atividade_id']);
          if ($DataFatalP->getPermissaoResult()['status'] == false) {

          $soma_data = new Funcoes();
          $nova_data = $soma_data->dia_in_data($this->Dados['data_fatal'], 1, "+");

          // Verificar se é fim de semanda ou não
          $data = getdate(strtotime($nova_data));
          if (($data['wday'] == 6) or ($data['wday'] == 0)) {
          if ($data['wday'] == 6){
          // se for sabado
          $dias = 2;
          } else {
          // se for domingo
          $dias = 1;
          }
          $novodia = new Funcoes();
          $nova_data = $novodia->dia_in_data($nova_data,$dias,"+");
          }

          $this->Dados['data_fatal'] = $nova_data;

          } else {
          $alertaMensagem = new AdmsAlertMensagem();
          $_SESSION['msg_dia'] = $alertaMensagem->alertMensagemSimples("A data fatal foi definida para o dia " . date('d/m/Y' ,strtotime($this->Dados['data_fatal'])), "info");
          }

          } while ($DataFatalP->getPermissaoResult()['status'] == false);
         */
        /*
         * Aqui realizo a chamada para a função que vai verificar se a atividade
         * vai ser definida para executar na data atual ou no dia seguinte.
         */
        $this->DataAtual = date('Y-m-d');
        $this->FuncionarioId = $this->Dados['adms_funcionario_id'];
        //$this->defineData();
        $verificarDataDisponivel = new VerificarDataDisponivel($this->FuncionarioId);
        $DataDefinida = $verificarDataDisponivel->getVertificarDataDisponivel();
        //var_dump($DataDefinida);
        $this->Dados['data_inicio_planejado'] = $DataDefinida['data_inicio_nova_atividade'];
        if ($DataDefinida['tempo_excedido_sc'] != false) {
            $this->TempoExcedido = $DataDefinida['tempo_excedido_sc'];
        } else {
            $this->TempoExcedido = 0;
        }


        //método para verficar se possui atividade registrada no mesmo atendimento pro mesmo funcionario
        $this->validaRegistroAtv();
        if ($this->jaExisteAtv) {
            // Caso a atividade já tenha sido cadastrada
            $UrlDestino = URLADM . 'atendimento-funcionarios/listar/1?aten=' . $this->Dados['adms_atendimento_id'];
            header("Location:$UrlDestino");
        } else {

            $this->Dados['created'] = date('Y-m-d H:i:s');
            $this->verificarExisteAtividade();
            if ($this->jaExiste) {

                $this->buscarUltimaAtiviFunc();
                if ($this->UltimaAtividade[0]) {
                    // Pegando a hora de termino da atividade anterior e passando para o inicio da nova atividade cadastrada
                    $this->Dados['hora_inicio_planejado'] = $this->UltimaAtividade[0]['hora_fim_planejado'];
                } else {
                    return $this->Resultado = false;
                }
            } else {

                $inicioAti = new AdmsRead();
                $inicioAti->fullRead("SELECT hora_inicio, hora_termino2 
                                            FROM adms_planejamento 
                                            WHERE adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");
                if ($inicioAti->getResultado()) {

                    $this->horaInicioFunc = $inicioAti->getResultado();

                    // Pegar o tempo excedito da atividade do dia anterior e somar com a hora de inicio planejado do funcionario para o proximo dia
                    if ($this->Dados['data_inicio_planejado'] == date('Y-m-d')) {

                        if ((date('H:i:s') < $this->horaInicioFunc[0]['hora_termino2']) and ( date('H:i:s') > $this->horaInicioFunc[0]['hora_inicio'])) {
                            $horaAtual = date('H:i:s');
                            $partes = explode(':', $horaAtual);
                        } else {
                            $partes = explode(':', $this->horaInicioFunc[0]['hora_inicio']);
                        }
                    } else {
                        $partes = explode(':', $this->horaInicioFunc[0]['hora_inicio']);
                    }

                    $segundosAtividades = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                    $resultado = $segundosAtividades + $this->TempoExcedido; // Pegando o tempo excedido e somando com a hora de inicio
                    $this->Dados['hora_inicio_planejado'] = gmdate("H:i:s", $resultado);
                }
            }

            //Função para verificar se a duração da atividade foi definida ou não
            // Pegando dados da atividade que está sendo cadastrada

            $this->buscarAtividade();


            //echo 'Valor sim ou não' . $this->Dados['simNao'];

            $this->Dados['hora'] = isset($this->Dados['hora']) ? $this->Dados['hora'] : 0; //Se vier valor atribui, senão atribui a 0
            $this->Dados['minuto'] = isset($this->Dados['minuto']) ? $this->Dados['minuto'] : 0;

            if ($this->Dados['simNao'] == 'option1' && ($this->Dados['hora'] + $this->Dados['minuto'] > 0)) { //As horas e minutos para comparação utiliza-se em inteiro (separados)
                //echo $this->Dados['hora'] + $this->Dados['minuto'];
                $duracao_atv = [$this->Dados['hora'], $this->Dados['minuto']];

                $this->Dados['duracao_atividade'] = date('H:i:s', strtotime(implode(':', $duracao_atv)));
            } else {
                $this->Dados['duracao_atividade'] = $this->DadosAtivi[0]['duracao'];
            }

            unset($this->Dados['hora']);
            unset($this->Dados['minuto']);
            unset($this->Dados['simNao']); //Retirando posição do array para não causar conflito no BD

            $this->Dados['at_tempo_restante'] = $this->Dados['duracao_atividade'];
            $this->Dados['ordem_atividade'] = $this->DadosAtivi[0]['ordem'];

            //echo $this->Dados['duracao_atividade'];

            //die();
            // Somando duração da atividade na hora de inicio
            // Passar os parametros no formato H:i:s
            $calcularHoraFimPl = new Funcoes();
            $this->Dados['hora_fim_planejado'] = $calcularHoraFimPl->somar_time_in_hours($this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado']);

            // Buscar Jornada para fazer comparação se será necessário somar a hora de almoço
            $jornadaFunc = new BuscarDuracaoJornadaT($this->FuncionarioId, $this->Dados['data_inicio_planejado']);
            $pausa_almoco = $jornadaFunc->getDuracaoJornada()['hora_termino'];
            $retorna_trabalho = $jornadaFunc->getDuracaoJornada()['hora_inicio2'];
            $start_job = $jornadaFunc->getDuracaoJornada()['hora_inicio'];
            if (empty($pausa_almoco)) {
                return $this->Resultado = false;
            }
            if (($this->Dados['hora_inicio_planejado'] < $pausa_almoco)and ( $pausa_almoco < $this->Dados['hora_fim_planejado'])) {
                $calculaAlmoco = new Funcoes();
                $totalTimeAlmoco = $calculaAlmoco->sbtrair_horas_in_hours($retorna_trabalho, $pausa_almoco);
                $this->Dados['hora_fim_planejado'] = $calculaAlmoco->somar_time_in_hours($totalTimeAlmoco, $this->Dados['hora_fim_planejado']);
            }
            if (($this->Dados['hora_inicio_planejado'] >= $pausa_almoco) and ( $this->Dados['hora_inicio_planejado'] < $retorna_trabalho)) {

                /*
                 * calcular se o tempo excedido da atividade anterior termina durante o horario de almoço, se sim, somar horario de almoço
                 * na hora_inicio_planejado da atividade sendo registrada e somar a duração da atividade definindo a hora_fim_planejado
                 */
                $verificarTimeExcedido = new Funcoes();
                $timeExcedido = $verificarTimeExcedido->segundos_to_hora($this->TempoExcedido);
                $horaInicioSemAlmoco = $verificarTimeExcedido->somar_time_in_hours($timeExcedido, $start_job);
                if ($horaInicioSemAlmoco > $pausa_almoco) {

                    $calcularInicioAfterAlmoco = new Funcoes();
                    $totalTimeAlmoco = $calcularInicioAfterAlmoco->sbtrair_horas_in_hours($retorna_trabalho, $pausa_almoco);
                    $this->Dados['hora_inicio_planejado'] = $calcularInicioAfterAlmoco->somar_time_in_hours($totalTimeAlmoco, $this->Dados['hora_inicio_planejado']);
                    $this->Dados['hora_fim_planejado'] = $calcularInicioAfterAlmoco->somar_time_in_hours($this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado']);
                } else {
                    // Caso a nova atividade a ser registrada inicie durante o almoço, será definida pra ela o novo inicio após o almoço
                    $this->Dados['hora_inicio_planejado'] = $retorna_trabalho;
                    $calculaAlmoco = new Funcoes();
                    $this->Dados['hora_fim_planejado'] = $calculaAlmoco->somar_time_in_hours($this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado']);
                }
            }


            // Corrigir erro ao registrar uma atividade de 6h que ultrapasse o expediente e almoço do dia seguinte
            //Criar objeto de AdmsAtendimentoFuncionarioReordenar para Inserir a ordem
            $inserirOrdem = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar();

            $inserirOrdem->inserirOrdemAtvFunc($this->Dados['adms_funcionario_id']);
            $this->Dados['ordem'] = $inserirOrdem->getResultado(); //se for a primeira será 1 senão será a ultima + 1

            //var_dump($this->Dados);
            //die();

            $regist = new AdmsCreateRow();
            $regist->exeCreate("adms_atendimento_funcionarios", $this->Dados);
            if ($regist->getResultado()) {
                $alertaMensagem = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alertaMensagem->alertMensagemJavaScript("Atividade definida!", "success");
                return $this->Resultado = true;
            } else {
                $alertaMensagem = new AdmsAlertMensagem();
                $_SESSION['msg'] = $alertaMensagem->alertMensagemJavaScript("Ocorreu um erro ao registrar. Tente novamente", "danger");
                return $this->Resultado = false;
            }
        }
    }

    // Definiar a data em que a atividade será registrada
    public function defineData($Funcionario = null, $Data = null) {
        if (!empty($Funcionario) and ! empty($Data)) {
            $this->FuncionarioId = $Funcionario;
            $novaData = $Data;
        } else {
            $novaData = $this->DataAtual;
        }

        $laco = 1;
        $cont = 1;
        while ($laco == 1) {
            //echo $cont ."\n";
            $this->atividadeDuracao($this->FuncionarioId, $novaData);

            if (!empty($Funcionario) and ! empty($Data)) {
                $this->buscarJornada($Funcionario, $Data);
                // buscar fim da jornada de trabalho e verificar se a ultima atividade registrada para o funcionário, a hora do fim planejado é menor que a hora do fim da jornada
                // $this->UltimaAtividade[0]['hora_fim_planejado']
                // $this->HoraTermino2 
            } else {
                $this->buscarJornada();
            }

            $this->buscarUltimaAtividadeDefineData($novaData);
            //echo $this->HoraTermino2;
            //echo $this->UltimaAtividadeLoop[0]['hora_fim_planejado'];

            echo $this->JornadaFunc[0]['total'] . '>' . $this->DuracaoTotalAtivi[0]['duracao_atividade_sc'] . ' ' . $this->HoraTermino2 . '>' . $this->UltimaAtividadeLoop[0]['hora_fim_planejado'];
            //die();

            if (($this->JornadaFunc[0]['total'] > $this->DuracaoTotalAtivi[0]['duracao_atividade_sc']) and ( $this->HoraTermino2 > $this->UltimaAtividadeLoop[0]['hora_fim_planejado'])) {

                $this->Dados['data_inicio_planejado'] = $novaData;
                //die();
                $laco = 0; // encerra o laço de repetição
                //break;
            } else {

                if ($this->HoraTermino2 < $this->UltimaAtividadeLoop[0]['hora_fim_planejado']) {

                    /*
                     * ATENÇÃO PAREI AQUI
                     * calcular o tempo excedido quando a soma total das atividades não ultrapassa a jornada de trabalho
                     * mas ultrapassa as 18 horas do dia
                     *
                     */

                    //Como entra apenas uma vez nessa condição, quando o horário da ultima atividade for maior que a HoraTermino2 o horário da ultima atividade pode ser definido igual a HoraTermino2
                    $help = explode(':', $this->HoraTermino2);
                    $data = new DateTime(date('H:i', strtotime($this->UltimaAtividadeLoop[0]['hora_fim_planejado'])));
                    $data->modify('-' . $help[0] . ' hours');
                    $data->modify('-' . $help[1] . ' minutes');
                    $resultado = $data->format('H:i:s');

                    $partes = explode(':', $resultado);
                    $resultado = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];

                    //$this->TempoExcedido = $resultado;
                    //echo $this->UltimaAtividadeLoop[0]['hora_fim_planejado'];
                    //echo $this->HoraTermino2;
                    //echo $resultado;

                    $this->TempoExcedido = $resultado;
                    //die;
                } else {
                    $this->TempoExcedido = "0";
                }


                //var_dump($partes)

                $data = new DateTime(date('Y-m-d', strtotime($novaData)));
                $data->modify('+1 day');
                $novaData = $data->format('Y-m-d');
                //echo $novaData;

                $this->Dados['data_inicio_planejado'] = $novaData;
            }
            var_dump($this->TempoExcedido);
            var_dump($this->Dados);
            $cont++;
        }
    }

    /*
     * get Para retornar data_inicio_planejado e TempoExcedido
     */

    public function getDefineData() {
        return ['tempo_excedido' => $this->TempoExcedido, 'data_inicio_planejado' => $this->Dados['data_inicio_planejado']];
    }

    // Buscar a ultima atividade na data selecionada para o funcionário selecionado
    public function buscarUltimaAtiviFunc($Funcionario = null, $Data = null) {

        if (!empty($Funcionario) and ! empty($Data)) {
            $this->Dados['adms_funcionario_id'] = $Funcionario;
            $this->Dados['data_inicio_planejado'] = $Data;
        }

        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT hora_fim_planejado, hora_inicio_planejado
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id 
        ORDER BY data_inicio_planejado DESC, hora_inicio_planejado DESC LIMIT :limit", "data_inicio_planejado={$this->Dados['data_inicio_planejado']}&adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");
        if ($dataHora->getResultado()) {

            $compara_hora_fim = $dataHora->getResultado()[0]['hora_fim_planejado'];
            $compara_hora_inicio = $dataHora->getResultado()[0]['hora_inicio_planejado'];

            $this->UltimaAtividade = $dataHora->getResultado();

            //var_dump($this->UltimaAtividade);
            //echo $this->UltimaAtividade[0]['hora_fim_planejado'];
            //die;
        }
    }
    
    public function getBuscarUltimaAtiviFunc() {
        return $this->UltimaAtividade;
    }
    
    public function buscarPrimeiraAtv($Funcionario = null, $Data = null){ //Traz os dados da menor ordem disponivel
        
        echo $Data;
        if (!empty($Funcionario) and !empty($Data)) {
            $this->Dados['adms_funcionario_id'] = $Funcionario;
        }
        
        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT hora_fim_planejado, hora_inicio_planejado, data_inicio_planejado, ordem, id
        FROM adms_atendimento_funcionarios 
        WHERE adms_funcionario_id=:adms_funcionario_id
        AND ordem = 
            (SELECT MIN(ordem) FROM adms_atendimento_funcionarios 
            WHERE adms_sits_atendimentos_funcionario_id <= :adms_sits_atendimentos_funcionario_id 
            AND adms_funcionario_id = :adms_funcionario_id AND data_inicio_planejado >= :data_inicio_planejado)  
            LIMIT :limit", "adms_funcionario_id={$this->Dados['adms_funcionario_id']}&data_inicio_planejado={$Data}&adms_sits_atendimentos_funcionario_id=3&limit=1");
            
        if ($dataHora->getResultado()) {
            
            $buscarJornada = new BuscarDuracaoJornadaT($this->Dados['adms_funcionario_id'], $Data);
            $hora_termino2 = $buscarJornada->getDuracaoJornada()['hora_termino2'];
            
            //echo $dataHora->getResultado()[0]['hora_fim_planejado'];
            //echo $hora_termino2;
            /*
            if($dataHora->getResultado()[0]['hora_fim_planejado'] > $hora_termino2){
                
                $somaDia = new Funcoes();
                //$somaDia->dia_in_data($Data, 1, "+");
                //echo 'entrou' . $Data;
                $Data = $somaDia->dia_in_data($Data, 1, "+");
                $this->buscarPrimeiraAtv($this->Dados['adms_funcionario_id'], $Data); //Função recursiva
            }else{ */
               
                $this->UltimaAtividade = $dataHora->getResultado();
                //var_dump($this->UltimaAtividade);
            //}
       
            //die;
        }
    }
    
    public function getBuscarPrimeiraAtv(){
        return $this->UltimaAtividade;
    }

    // Buscar a ultima atividade na data selecionada para o funcionário selecionado
    public function buscarUltimaAtividadeDefineData($DataLoop = null) {
        $this->DataLoop = $DataLoop;
        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT hora_fim_planejado, hora_inicio_planejado
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id 
        ORDER BY data_inicio_planejado DESC, hora_inicio_planejado DESC LIMIT :limit", "data_inicio_planejado={$this->DataLoop}&adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");
        if ($dataHora->getResultado()) {
            /*
             *  Caso a ultima atividade tenha inicio antes das 12 e finalizada depois das 12
             * (supondo que o horario de almoço do funcionário comece as 12),
             * calcular a duração do tempo para almoço que o funicionário tem
             * e atribuir essa soma na hora_fim_planejado, que servirá como base para
             * a hora de inicio da próxima atividade
             *
             * $this->HoraInicio2 - $this->HoraTermino
             */

            $diferencaHoras = new Funcoes();
            $Duracao_almoco = $diferencaHoras->sbtrair_horas_in_hours($this->HoraInicio2, $this->HoraTermino);
            $hora_fim_ultima_ativ = $this->UltimaAtividadeLoop[0]['hora_fim_planejado'];
            $hora_inicio_ultima_ativ = $this->UltimaAtividadeLoop[0]['hora_inicio_planejado'];
            if (($hora_inicio_ultima_ativ < $this->HoraTermino) and ( $hora_fim_ultima_ativ > $this->HoraTermino)) {
                /*
                 * Aqui vai somar a $Duracao_almoco com $this->UltimaAtividadeLoop[0]['hora_fim_planejado']
                 *
                 * Atenção, quase pronto, mas falta testar. ta dando erro
                 */

                $this->UltimaAtividadeLoop[0]['hora_fim_planejado'] = $diferencaHoras->somar_time_in_hours($Duracao_almoco, $this->UltimaAtividadeLoop[0]['hora_fim_planejado']);
            } else {
                $this->UltimaAtividadeLoop = $dataHora->getResultado();
            }
            //var_dump($this->UltimaAtividadeLoop);
            //die;
            //$this->UltimaAtividadeLoop = $dataHora->getResultado();
        } else {
            $this->UltimaAtividadeLoop[0]['hora_fim_planejado'] = "08:00:00";
        }
    }

    public function getBuscarUltimaAtividadeDefineData() {

        return $this->UltimaAtividadeLoop;
    }

    // Verificar se já existe atividade registrada para o funcionário na data especificado no registro
    public function verificarExisteAtividade($Funcionario = null, $Data = null) {

        if (!empty($Funcionario) and ! empty($Data)) {
            $this->Dados['adms_funcionario_id'] = $Funcionario;
            $this->Dados['data_inicio_planejado'] = $Data;
        }

        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT id 
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "data_inicio_planejado={$this->Dados['data_inicio_planejado']}&adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");

        if ($dataHora->getResultado()) {
            $this->jaExiste = $dataHora->getResultado();
        }
    }

    public function getVerificarExisteAtividade() {
        return $this->jaExiste;
    }

    // Verificar se já existe data e hora registrada para outra atividade
    private function buscarFuncionarioDataHora() {
        $this->Dados['hora_inicio_planejado'] = date('H:i:s', strtotime($this->Dados['hora_inicio_planejado']));
        $this->Dados['data_inicio_planejado'] = date('Y-m-d', strtotime($this->Dados['data_inicio_planejado']));

        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT id 
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado 
        AND hora_inicio_planejado=:hora_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "data_inicio_planejado={$this->Dados['data_inicio_planejado']}&hora_inicio_planejado={$this->Dados['hora_inicio_planejado']}&adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");

        if ($dataHora->getResultado()) {
            $this->jaExiste = $dataHora->getResultado();
        }
    }

    private function buscarAtividade() {
        $atividade = new AdmsRead();
        $atividade->fullRead("SELECT nome, duracao, ordem FROM adms_atividades WHERE id=:id LIMIT :limit", "id={$this->Dados['adms_atividade_id']}&limit=1");
        if ($atividade->getResultado()) {
            $this->DadosAtivi = $atividade->getResultado();
        }
    }

    public function excluirFuncionario($Aten_id = null, $Func_id = null, $Ativ_id = null) {
        $this->AtenId = (int) $Aten_id;
        $this->FuncId = (int) $Func_id;
        $this->AtivId = (int) $Ativ_id;

        $exFunc = new AdmsDelete();
        $exFunc->exeDelete("adms_atendimento_funcionarios", "adms_atendimento_id=:adms_atendimento_id AND adms_funcionario_id=:adms_funcionario_id AND adms_atividade_id=:adms_atividade_id", "adms_atendimento_id={$this->AtenId}&adms_funcionario_id={$this->FuncId}&adms_atividade_id={$this->AtivId}");
        $this->Resultado = $exFunc->getResultado();
        return $this->Resultado;
    }

    /*
     * Planejamento do funcionário
     */

    public function verPlanejamentoFuncionario($FuncionarioId = null, $Data = null) {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->Data = date('Y-m-d', strtotime($Data));

        $funcionarios = new AdmsRead();
        $funcionarios->fullRead("SELECT aten_fun.id, aten_fun.duracao_atividade, aten_fun.data_inicio_planejado, aten_fun.hora_inicio_planejado, aten_fun.data_fatal,
        demanda.nome nome_demanda,
        atividade.nome nome_atividade,
        atendimento.id id_atendimento, atendimento.descricao descricao_atendimento
        FROM adms_atendimento_funcionarios aten_fun
        INNER JOIN adms_demandas demanda ON demanda.id = aten_fun.adms_demanda_id
        INNER JOIN adms_atividades atividade ON atividade.id = aten_fun.adms_atividade_id
        INNER JOIN adms_atendimentos atendimento ON atendimento.id = aten_fun.adms_atendimento_id
        WHERE aten_fun.data_inicio_planejado=:data_inicio_planejado
        AND aten_fun.adms_funcionario_id=:funcionario", "data_inicio_planejado={$this->Data}&funcionario={$this->FuncionarioId}");
        $this->Resultado = $funcionarios->getResultado();
    }

    public function funcionarioPlanejamento($FuncionarioId = null) {
        $this->FuncionarioId = (int) $FuncionarioId;
        $func = new AdmsRead();
        $func->fullRead("SELECT nome nome_funcionario
        FROM adms_usuarios
        WHERE id=:id LIMIT :limit", "id={$this->FuncionarioId}&limit=1");
        $this->Resultado = $func->getResultado();
    }

    public function jornadaTrabalho($FuncionarioId = null, $Data = null) {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->Data = date('Y-m-d', strtotime($Data));

        $this->verificarHoraExtra();
        if ($this->HoraExtra) {

            $jornada = new AdmsRead();
            $jornada->fullRead("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(extra.total)) + (TIME_TO_SEC(plan.jornada_trabalho)))  AS jornada_trabalho
            FROM adms_hora_extra extra
            INNER JOIN adms_planejamento plan ON plan.adms_funcionario_id = extra.adms_usuario_id
            WHERE extra.adms_usuario_id =:id
            AND extra.data =:data_d", "id={$this->FuncionarioId}&data_d={$this->Data}");
            $this->Resultado = $jornada->getResultado();
        } else {
            $jornada = new AdmsRead();
            $jornada->fullRead("SELECT jornada_trabalho
            FROM adms_planejamento
            WHERE adms_funcionario_id =:id 
            LIMIT :limit", "id={$this->FuncionarioId}&limit=1");
            $this->Resultado = $jornada->getResultado();
        }
    }

    private function verificarHoraExtra() {
        $verificar = new AdmsRead();
        $verificar->fullRead("SELECT *
        FROM adms_hora_extra 
        WHERE adms_usuario_id =:id
        AND data =:data_d", "id={$this->FuncionarioId}&data_d={$this->Data}");
        $this->HoraExtra = $verificar->getResultado();
    }

    public function atividadeDuracao($FuncionarioId = null, $Data = null) {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->Data = date('Y-m-d', strtotime($Data));
        $ativDura = new AdmsRead();
        $ativDura->fullRead("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duracao_atividade)))  AS duracao_atividade, SUM(TIME_TO_SEC(duracao_atividade))  AS duracao_atividade_sc
        FROM adms_atendimento_funcionarios
        WHERE adms_funcionario_id =:id
        AND data_inicio_planejado =:data_p", "id={$this->FuncionarioId}&data_p={$this->Data}");
        $this->Resultado = $ativDura->getResultado();
        $this->DuracaoTotalAtivi = $ativDura->getResultado();
    }

    public function getAtividadeDuracao() {
        return $this->DuracaoTotalAtivi;
    }

    private function buscarDuracaoAtv() { //Mostra a duração das atividades naquela data para tal funcionario
        $buscarDuracaoAtv = new AdmsRead();
        $buscarDuracaoAtv->fullRead("
        SELECT SUM(TIME_TO_SEC(duracao_atividade)) AS duracao_atv
        FROM adms_atendimento_funcionarios
        WHERE data_inicio_planejado = :data_i_planejado and adms_funcionario_id = :adms_func_id LIMIT :limit", "data_i_planejado={$this->Dados['data_inicio_planejado']}&adms_func_id={$this->Dados['adms_funcionario_id']}&limit=1"
        );

        $duracaoTotalAtv = $buscarDuracaoAtv->getResultado(); //Método comparaJornada recebe o resultado da consulta anterior e atribuir para duracaoTotalAtv
        //var_dump($duracaoTotalAtv);
        //die();

        return $duracaoTotalAtv;
    }

    public function buscarJornada($Funcionario = null, $Data = null) {

        if (!empty($Funcionario) and ! empty($Data)) {
            $this->Dados['adms_funcionario_id'] = $Funcionario;
            $this->Dados['data_inicio_planejado'] = $Data;
        }

        $this->verificarHoraExtra();

        $jornadaDia = new AdmsRead();

        if ($this->HoraExtra) { //Soma as horas extras para aquele dia do funcionario e o resultado é somado com sua jornada normal
            $jornadaDia->fullRead("
                SELECT TIME_TO_SEC(planejamento.jornada_trabalho) + SUM(TIME_TO_SEC(hora_extra.total)) as total, planejamento.hora_termino2, 
                       planejamento.hora_inicio2, planejamento.hora_inicio, planejamento.hora_termino
                FROM adms_hora_extra hora_extra 
                INNER JOIN adms_planejamento planejamento 
                ON hora_extra.adms_usuario_id = planejamento.adms_funcionario_id
                WHERE hora_extra.adms_usuario_id = :usuario and hora_extra.data = :data
                GROUP BY planejamento.hora_termino2", "usuario={$this->Dados['adms_funcionario_id']}&data={$this->Dados['data_inicio_planejado']}"
            );
        } else { //Traz apenas a jornada normal do funcionário cadastrado
            $jornadaDia->fullRead("
                SELECT TIME_TO_SEC(planejamento.jornada_trabalho) as total, planejamento.hora_termino2 , 
                       planejamento.hora_inicio2, planejamento.hora_inicio ,planejamento.hora_termino
                FROM adms_planejamento planejamento
                WHERE adms_funcionario_id = :funcionario
                GROUP BY planejamento.hora_termino2", "funcionario={$this->Dados['adms_funcionario_id']}"
            );
        }
        $this->horaInicio1 =  $jornadaDia->getResultado()[0]['hora_inicio'];
        $this->JornadaFunc = $jornadaDia->getResultado();
        $this->HoraTermino2 = $jornadaDia->getResultado()[0]['hora_termino2'];
        $this->HoraInicio2 = $jornadaDia->getResultado()[0]['hora_inicio2'];
        $this->HoraTermino = $jornadaDia->getResultado()[0]['hora_termino'];
        $jornada = $jornadaDia->getResultado(); //obtém o resultado da jornada do if ou do else
        //var_dump($jornada);
        //die();
        return $jornada;
    }

    public function getBuscarJornada() {

        $this->Resultado = ["hora_termino2" => $this->HoraTermino2, "jornadaFunc" => $this->JornadaFunc[0]['total'], "hora_termino" => $this->HoraTermino, "hora_inicio2" => $this->HoraInicio2, "hora_inicio" => $this->horaInicio1];
        //var_dump($this->Resultado);
        //die();
        
        return $this->Resultado;
    }

    public function comparaJornada() {

        $duracaoTotalAtv = $this->buscarDuracaoAtv(); //Recebe o resultado do método (duracao das ativadades em segundos)
        $jornada = $this->buscarJornada();

        /*
          var_dump($duracaoTotalAtv);
          var_dump($jornada);
         */

        if ($duracaoTotalAtv[0]['duracao_atv'] > $jornada[0]['total']) { //array com chaves relacionadas às colunas (o array é numerico e possui o indice da coluna da tabela [bidimensional])
            return false; //Ultrapassou a jornada para o funcionario naquele dia    
        } else {
            return true; //Ainda é possivel realizar atividades há horas sobrando na jornada do funcionario na data especificada
        }
    }

    private function validaRegistroAtv() {

        $validaRegistro = new AdmsRead();
        $validaRegistro->fullRead("SELECT id 
        FROM adms_atendimento_funcionarios 
        WHERE adms_atendimento_id = :atendimento 
        AND adms_funcionario_id = :funcionario_id
        AND adms_atividade_id = :atividade_id LIMIT :limit", "atendimento={$this->Dados['adms_atendimento_id']}&funcionario_id={$this->Dados['adms_funcionario_id']}&atividade_id={$this->Dados['adms_atividade_id']}&limit=1");

        $this->jaExisteAtv = $validaRegistro->getResultado();
    }

 

    public function buscarDuracaoMinAtv($atenId) {



        $duracao_min = new AdmsRead();
        $duracao_min->fullRead("SELECT nome, duracao, duracao_min FROM adms_atividades WHERE adms_demanda_id = (SELECT adms_demanda_id FROM adms_atendimentos WHERE id = :id)
                  AND id NOT IN (SELECT adms_atividade_id FROM adms_atendimento_funcionarios WHERE adms_atendimento_id = :id)", "id={$atenId}");

        $this->Resultado = $duracao_min->getResultado();
    }

}
