<?php

/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 22/04/2019
 * Time: 15:43
 */

namespace App\adms\Models;

use App\adms\Models\AdmsReordenarData;
use App\adms\Models\AdmsAtendimentoFuncionariosReordenarPriori;
use App\adms\Models\AdmsAtendimentoFuncionarios;
use App\adms\Models\helper\AdmsAlertMensagem;
use App\adms\Models\funcoes\VerificarDataDisponivel;
use App\adms\Models\funcoes\BuscarDuracaoJornadaT;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\helper\AdmsRead;
use App\adms\Models\helper\AdmsUpdate;
use DateTime;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsAtendimentoFuncionarioEditar {

    private $Dados;
    private $Condicao;
    private $Atividade;
    private $DataAtual;
    private $horaAtual;
    private $UltimaAtividade;
    private $jaExiste;
    private $Data;
    private $FuncionarioId;
    private $HoraExtra;
    private $horaInicioFunc;
    private $JornadaFunc;
    private $DuracaoTotalAtivi;
    private $TempoExcedido = 0;
    private $DadosAtivi;
    private $ultimaOrdem;
    private $ordemRetirada;
    private $primeiraAtv;
    private $booleanReordenar;
    private $status;
    private $verificaPriori;

    /**
     * @param mixed $Dados
     * Receber array de dados para atualizar atendimento e array de condições
     * @param array $Condicao
     */
    public function setAtividade(array $Dados, array $Condicao) {
        $this->Dados = $Dados;
        $this->Condicao = $Condicao;

        var_dump($this->Condicao);
        //die();

        $this->Dados['data_inicio_planejado'] = date('Y-m-d'); //Lembrar de colocar para a validação esta data quando tiver prioridade
        $this->FuncionarioId = $this->Dados['adms_funcionario_id'];

        if ($this->Dados['prioridade'] == '1') {
            //die();
            $this->status = $this->definirPrioridade();
            //CHAMAR FUNÇÃO PARA VERIFICAR SE HÁ PRIORIDADE PRO MESMO FUNCIONÁRIO AQUI
            if ($this->status == 1) {
                $this->Atividade['status'] = true;
                $this->Atividade['msg'] = "Atividade atualizada com sucesso";
            } else if ($this->status == 2) {
                $this->Atividade['status'] = true;
                $this->Atividade['msg'] = "Atividade atualizada com sucesso, foi alterada apenas sua prioridade";
            } else {
                $this->Atividade['status'] = false;
                $this->Atividade['msg'] = "A atividade não foi atualizada";
            }
        } else {
            $this->status = $this->updateAtividade();

            if ($this->status == 1) {
                $this->Atividade['status'] = true;
                $this->Atividade['msg'] = "Atividade atualizada com sucesso";
            } else {
                $this->Atividade['status'] = false;
                $this->Atividade['msg'] = "A atividade não foi atualizada";
            }
        }



        //$this->Atividade = ['status'=>'','msg'=>''];
    }

    public function getAtividade() {
        return $this->Atividade;
    }
    
    private function verificarPrioridade(){
        
        $verificarPriori = new AdmsRead();
        
        $verificarPriori->fullRead("SELECT prioridade FROM adms_atendimento_funcionarios WHERE id = :id", "id={$this->Condicao['id_aten_fun']}");
        $this->verificaPriori = $verificarPriori->getResultado()['prioridade'];
        
        var_dump($this->verificaPriori);
        die();
        
    }

    /*
     * Atualizar Atividade
     */

    private function updateAtividade() {
        /*
         * Aqui realizo a chamada para a função que vai verificar se a atividade
         * vai ser definida para executar na data atual ou no dia seguinte.
         */
        //$this->horaAtual = date('H:i:s');
        //$this->defineData();

        $infoAtividades = new AdmsAtendimentoFuncionarios();


        $verificarDataDisponivel = new VerificarDataDisponivel($this->FuncionarioId, $this->Dados['data_inicio_planejado']);
        $DataDefinida = $verificarDataDisponivel->getVertificarDataDisponivel();

        $this->Dados['data_inicio_planejado'] = $DataDefinida['data_inicio_nova_atividade'];

        if ($DataDefinida['tempo_excedido_sc'] != false) {
            $this->TempoExcedido = $DataDefinida['tempo_excedido_sc'];
        } else {
            $this->TempoExcedido = 0;
        }


        $this->Dados['modified'] = date('Y-m-d H:i:s');
        //var_dump($this->Dados['prioridade']);
        //die();

        $this->verificarExisteAtividade();

        if ($this->jaExiste) {
            //die();
            $infoAtividades->buscarUltimaAtiviFunc($this->FuncionarioId, $this->Dados['data_inicio_planejado']);
            $this->UltimaAtividade = $infoAtividades->getBuscarUltimaAtiviFunc();

            if ($this->UltimaAtividade[0]) {
                // Pegando a hora de termino da atividade anterior e passando para o inicio da nova atividade cadastrada
                $this->Dados['hora_inicio_planejado'] = $this->UltimaAtividade[0]['hora_fim_planejado'];
            } else {
                $this->Atividade['status'] = false;
                $this->Atividade['msg'] = "Não foi possível encontrar a última atividade do funcionário";
            }
        } else { //Não existe atividade para aquela data e prioridade é 2, sendo prioridade 1 a atividade começará no inicio da jornada ou hora atual entrando nesta condição
            $inicioAti = new AdmsRead();
            $inicioAti->fullRead("SELECT hora_inicio, hora_termino2 
                FROM adms_planejamento 
                WHERE adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");

            if ($inicioAti->getResultado()) {

                $this->horaInicioFunc = $inicioAti->getResultado();

                // Pegar o tempo excedito da atividade do dia anterior e somar com a hora de inicio planejado do juncionario para o proximo dia
                if ($this->Dados['data_inicio_planejado'] == date('Y-m-d')) {
                    //OBSERVAR MELHOR ESSA CONDIÇÃO PARA QUANDO HOUVER TEMPO EXCEDIDO!
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

        echo $this->Dados['hora_inicio_planejado'] . ', ' . $this->Dados['data_inicio_planejado'];
        //die();
        $this->buscarAtividade();
        $this->Dados['duracao_atividade'] = $this->DadosAtivi[0]['duracao_atividade'];
        $this->Dados['at_tempo_restante'] = $this->DadosAtivi[0]['duracao_atividade'];
        $this->Dados['ordem_atividade'] = $this->DadosAtivi[0]['ordem'];

        $calcularHoraFimPl = new Funcoes();
        $this->Dados['hora_fim_planejado'] = $calcularHoraFimPl->somar_time_in_hours($this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado']);

        $verificaAlmoco = new AdmsReordenarData();

        //echo $this->FuncionarioId;
        //die();

        if ($this->TempoExcedido > 0 && $this->TempoExcedido != NULL) {
            $verificaAlmoco->buscarUltimaAtiviFuncAlmoco($this->Dados['hora_fim_planejado'], $this->Dados['data_inicio_planejado'], $this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado'], $this->TempoExcedido, $this->FuncionarioId);
        } else {
            $verificaAlmoco->buscarUltimaAtiviFuncAlmoco($this->Dados['hora_fim_planejado'], $this->Dados['data_inicio_planejado'], $this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado'], NULL, $this->FuncionarioId);
        }

        //$verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco();

        if ($verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco() != FALSE) { //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
            $this->Dados['hora_inicio_planejado'] = $verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio'];
            $this->Dados['hora_fim_planejado'] = $verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
        }
        var_dump($this->Dados);
        //die();
        //echo "aqui";

        $inserirOrdem = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar();

        $inserirOrdem->inserirOrdemAtvFunc($this->Dados['adms_funcionario_id']);
        $this->Dados['ordem'] = $inserirOrdem->getResultado(); //Busca a ultima ordem do funcionário e adiciona 1, necessario inserir primeiro pois o valor func_id a ser salvo na classe é outro

        $reordenar = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar(); //Independente da prioridade o planejamento do funcionário antigo sempre será reordenado o que muda é a inserção da ordem

        $reordenar->buscarUltOrdemAtvFunc($this->Condicao['adms_funcionario_id_ant']); //Retorna a ordem e atribui o id do funcinario na classe         
        $this->ultimaOrdem = (int) $reordenar->getResultado()[0]['ordem'];

        $reordenar->buscarOrdem($this->Condicao['id_aten_fun']); //Verificar se há necessidade de reordenar as atividades e o planejamento
        $this->ordemRetirada = $reordenar->getResultado();

        $infoAtividades->verificarExisteAtividade($this->FuncionarioId, $this->Dados['data_inicio_planejado']);
        $this->jaExiste = $infoAtividades->getVerificarExisteAtividade(); //verificar a forma de recebimento desses dados
        //echo $this->ultimaOrdem . '<' . $this->ordemRetirada; //Buscando ordem do antigo funcionario antes de atualizar
        // Realizar a atualização da atividade
        //die();
        $update = new AdmsUpdate();
        $update->exeUpdate("adms_atendimento_funcionarios", $this->Dados, "WHERE id=:id_aten_fun AND adms_atendimento_id=:atendimento AND adms_atividade_id=:atividade", "id_aten_fun={$this->Condicao['id_aten_fun']}&atendimento={$this->Condicao['adms_atendimento_id']}&atividade={$this->Condicao['adms_atividade_id']}");

        //die();
        if ($update->getResultado()) {
            // Passando para o atributo Atividade o status = true, registro realizado com sucesso
            //Permitir para prioridade 1 pois reordenará as atividades do antigo funcionario
            if ($this->ordemRetirada < $this->ultimaOrdem) {
                $reordenar->reordenarAtv();
            }
            return 1;
        } else {
            // Passando para o atributo Atividade o status = false, registro realizado não foi realizado
            return 0;
        }
    }

    /*
     *  Definiar a data em que a atividade será registrada
     */

    private function defineData() {
        $novaData = $this->DataAtual;
        $laco = 1;
        while ($laco == 1) {
            $this->atividadeDuracao($this->FuncionarioId, $novaData);
            $this->buscarJornada();
            //var_dump($this->JornadaFunc);
            //var_dump($this->DuracaoTotalAtivi);
            //die;
            if ($this->JornadaFunc[0]['total'] > $this->DuracaoTotalAtivi[0]['duracao_atividade_sc']) {
                /*
                 * Aqui acrescento no array Dados o valor data_inicio_planejado
                 */
                $this->Dados['data_inicio_planejado'] = $novaData;
                $laco = 0;
                //break;
            } else {
                // Calculando o tempo excedido
                $resultado = $this->DuracaoTotalAtivi[0]['duracao_atividade_sc'] - $this->JornadaFunc[0]['total'];
                $this->TempoExcedido = $resultado;
                //echo $resultado;

                $data = new DateTime(date('Y-m-d', strtotime($novaData)));
                $data->modify('+1 day');
                $novaData = $data->format('Y-m-d');
                //echo $novaData;
                $this->Dados['data_inicio_planejado'] = $novaData;
            }
        }
    }

    /*
     * Verificar se já existe atividade registrada para o funcionário na data especificado no registro
     */

    private function verificarExisteAtividade() {
        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT id 
                                    FROM adms_atendimento_funcionarios 
                                    WHERE data_inicio_planejado=:data_inicio_planejado
                                    AND adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "data_inicio_planejado={$this->Dados['data_inicio_planejado']}&adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");

        if ($dataHora->getResultado()) {
            $this->jaExiste = $dataHora->getResultado();
        }
    }

    /*
     * Buscar a ultima atividade na data selecionada para o funcionário selecionado
     */

    private function buscarUltimaAtiviFunc() {
        $dataHora = new AdmsRead();
        $dataHora->fullRead("SELECT hora_fim_planejado 
        FROM adms_atendimento_funcionarios 
        WHERE data_inicio_planejado=:data_inicio_planejado
        AND adms_funcionario_id=:adms_funcionario_id 
        ORDER BY data_inicio_planejado DESC, hora_inicio_planejado DESC LIMIT :limit", "data_inicio_planejado={$this->Dados['data_inicio_planejado']}&adms_funcionario_id={$this->Dados['adms_funcionario_id']}&limit=1");

        if ($dataHora->getResultado()) {
            $this->UltimaAtividade = $dataHora->getResultado();
        }
    }

    /*
     * Buscar a duração da atividade a ser atualizada
     */

    private function buscarAtividade() {

        $buscaAtividade = new AdmsRead();
        $buscaAtividade->fullRead("SELECT aten_func.duracao_atividade, atv.ordem FROM adms_atendimento_funcionarios aten_func 
                                   INNER JOIN adms_atividades atv ON aten_func.adms_atividade_id = atv.id  
                                   WHERE aten_func.id = :id LIMIT :limit", "id={$this->Condicao['id_aten_fun']}&limit=1");
        if ($buscaAtividade->getResultado()) {
            $this->DadosAtivi = $buscaAtividade->getResultado();
            //var_dump($this->DadosAtivi);
        }
    }

    /*
     * Somar a duração total de todas as atividades do funcionário numa data especifica
     */

    public function atividadeDuracao($FuncionarioId = null, $Data = null) {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->Data = date('Y-m-d', strtotime($Data));
        $ativDuracao = new AdmsRead();
        $ativDuracao->fullRead("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duracao_atividade)))  AS duracao_atividade, SUM(TIME_TO_SEC(duracao_atividade))  AS duracao_atividade_sc
                                        FROM adms_atendimento_funcionarios
                                        WHERE adms_funcionario_id =:id
                                        AND data_inicio_planejado =:data_p", "id={$this->FuncionarioId}&data_p={$this->Data}");
        $this->DuracaoTotalAtivi = $ativDuracao->getResultado();
    }

    /*
     * Buscar a jornada de trabalho do funcionário, incluir hora extra se houver na data especifica
     */

    private function buscarJornada() {

        // Verificar se tem hora extra na data definida no metodo definiData()
        $this->verificarHoraExtra();

        $jornadaDia = new AdmsRead(); // Estanciando o objeto Read
        if ($this->HoraExtra) {
            // Soma as horas extras para aquele dia do funcionario e o resultado é somado com sua jornada normal
            $jornadaDia->fullRead("SELECT TIME_TO_SEC(planejamento.jornada_trabalho) + SUM(TIME_TO_SEC(hora_extra.total)) as total 
                                                FROM adms_hora_extra hora_extra 
                                                INNER JOIN adms_planejamento planejamento 
                                                ON hora_extra.adms_usuario_id = planejamento.adms_funcionario_id
                                                WHERE hora_extra.adms_usuario_id = :usuario and hora_extra.data = :data", "usuario={$this->Dados['adms_funcionario_id']}&data={$this->Dados['data_inicio_planejado']}"
            );
        } else {
            //Trás apenas a jornada normal do funcionário cadastrado
            $jornadaDia->fullRead("SELECT TIME_TO_SEC(planejamento.jornada_trabalho) as total 
                                                FROM adms_planejamento planejamento
                                                WHERE adms_funcionario_id = :funcionario", "funcionario={$this->Dados['adms_funcionario_id']}"
            );
        }
        // Obtém o resultado da jornada do if ou do else
        $this->JornadaFunc = $jornadaDia->getResultado();
    }

    /*
     * Verificar se o funcionário tem hora extra numa data especifica
     */

    private function verificarHoraExtra() {
        $verificar = new AdmsRead();
        $verificar->fullRead("SELECT id
                                        FROM adms_hora_extra 
                                        WHERE adms_usuario_id =:id
                                        AND data =:data_d", "id={$this->FuncionarioId}&data_d={$this->Data}");
        $this->HoraExtra = $verificar->getResultado();
    }

    private function definirPrioridade() {
        
        //Função para verificar se a atv já tem prioridade

        $novaData = new AdmsReordenarData();
        $this->Dados['data_inicio_planejado'] = $novaData->verificarData($this->Dados['data_inicio_planejado']); //Verificar se é fds ou feriado

        $infoAtividades = new AdmsAtendimentoFuncionarios();

        $infoAtividades->buscarPrimeiraAtv($this->FuncionarioId, $this->Dados['data_inicio_planejado']); //A partir da menor ordem aonde a atividade está disponível
        var_dump($infoAtividades->getBuscarPrimeiraAtv());
        //die();

        if ($infoAtividades->getBuscarPrimeiraAtv() != NULL) {
            $this->Dados['data_inicio_planejado'] = $infoAtividades->getBuscarPrimeiraAtv()[0]['data_inicio_planejado'];
            $this->Condicao['ordem'] = (int) $infoAtividades->getBuscarPrimeiraAtv()[0]['ordem'];
            $this->Condicao['hora_inicio_planejado'] = (int) $infoAtividades->getBuscarPrimeiraAtv()[0]['hora_inicio_planejado']; //Hora de inicio da primeira atividade
            //$this->defineHoraDataPrioridade($infoAtividades->getBuscarPrimeiraAtv());
        } else {

            if ($this->updateAtividade() == 1) {
                return 1;
            } else {
                return 0;
            }

            $this->Condicao['ordem'] = NULL;
        }

        $reordenarPriori = new AdmsAtendimentoFuncionariosReordenarPriori();

        $this->Condicao['ordemMax'] = $reordenarPriori->buscarUltOrdemAtvFunc();


        $this->Dados['modified'] = date('Y-m-d H:i:s');

        $this->buscarAtividade();

        //var_dump($this->DadosAtivi[0]['duracao_atividade']);
        //die();

        $this->Dados['duracao_atividade'] = $this->DadosAtivi[0]['duracao_atividade'];
        $this->Dados['at_tempo_restante'] = $this->DadosAtivi[0]['duracao_atividade'];
        $this->Dados['ordem_atividade'] = $this->DadosAtivi[0]['ordem'];

        //die();
        if (!is_null($this->Condicao['ordem'])) {
            $this->Dados['ordem'] = $this->Condicao['ordem']; //Ordens para listar na função corretamente
            //die();
            $this->booleanReordenar = $reordenarPriori->reordenarAtvPriori($this->Condicao['ordem'], $this->FuncionarioId, $this->Dados['duracao_atividade'], $this->Dados['data_inicio_planejado'], $this->Condicao['hora_inicio_planejado'], $this->Condicao['adms_funcionario_id_ant'], $this->Condicao['id_aten_fun']);
            var_dump($this->booleanReordenar);

            //die();
            // if(!empty($this->boleadnReordenar))
            if (!is_null($this->booleanReordenar)) {

                if ($this->booleanReordenar == 2) {

                    $priori['prioridade'] = $this->Dados['prioridade'];

                    $update = new AdmsUpdate();
                    $update->exeUpdate("adms_atendimento_funcionarios", $priori, "WHERE id=:id_aten_fun AND adms_atendimento_id=:atendimento AND adms_atividade_id=:atividade", "id_aten_fun={$this->Condicao['id_aten_fun']}&atendimento={$this->Condicao['adms_atendimento_id']}&atividade={$this->Condicao['adms_atividade_id']}");

                    return $this->booleanReordenar;
                } else if ($this->booleanReordenar == 1) {
                    //die();
                    //CHAMAR FUNÇÃO EDITAR INSERINDO APENAS AO FINAL COM PRIORIDADE 1
                    if ($this->updateAtividade() == 1) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
            //die();
        } /*else {
            $inserirOrdem = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar();

            $inserirOrdem->inserirOrdemAtvFunc($this->Dados['adms_funcionario_id']);
            $this->Dados['ordem'] = $inserirOrdem->getResultado(); //Busca a ultima ordem do funcionário e adiciona 1, necessario inserir primeiro pois o valor func_id a ser salvo na classe é outro
        }*/

        if ($reordenarPriori->getbuscarMinOrdemDataPriori()) { //PENSAR EM CRIAR UMA CLASSE SEPARADA
            $this->Dados['hora_inicio_planejado'] = $reordenarPriori->getDadosAtvPriori()['hora_inicio_planejado'];
            $calcularHoraFimPl = new Funcoes();
            //Utilizar regra para horario de almoço e fim de jornada
            $this->Dados['hora_fim_planejado'] = $reordenarPriori->getDadosAtvPriori()['hora_fim_planejado'];
            $this->Dados['data_inicio_planejado'] = $reordenarPriori->getbuscarMinOrdemDataPriori()['data_inicio_planejado'];
            $this->Dados['ordem'] = $reordenarPriori->getbuscarMinOrdemDataPriori()['ordem']; //Ordem final


            var_dump($this->Dados);
            //die();
            /*
              $verificaAlmoco = new AdmsReordenarData();

              $verificaAlmoco->buscarUltimaAtiviFuncAlmoco($this->Dados['hora_fim_planejado'], $this->Dados['data_inicio_planejado'], $this->Dados['duracao_atividade'], $this->Dados['hora_inicio_planejado'], NULL, $this->FuncionarioId);

              //$verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco();

              if ($verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco() != FALSE) { //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
              $this->Dados['hora_inicio_planejado'] = $verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio'];
              $this->Dados['hora_fim_planejado'] = $verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
              }

             */
        }

        $reordenar = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar(); //Independente da prioridade o planejamento do funcionário antigo sempre será reordenado o que muda é a inserção da ordem

        $reordenar->buscarUltOrdemAtvFunc($this->Condicao['adms_funcionario_id_ant']); //Retorna a ordem e atribui o id do funcinario na classe         
        $this->ultimaOrdem = (int) $reordenar->getResultado()[0]['ordem'];

        $reordenar->buscarOrdem($this->Condicao['id_aten_fun']); //Verificar se há necessidade de reordenar as atividades e o planejamento
        $this->ordemRetirada = $reordenar->getResultado();


        var_dump($this->Dados);
        //die();
        //VERIFICAR ORDEM ATRIBUIDA AQUI
        $update = new AdmsUpdate();
        $update->exeUpdate("adms_atendimento_funcionarios", $this->Dados, "WHERE id=:id_aten_fun AND adms_atendimento_id=:atendimento AND adms_atividade_id=:atividade", "id_aten_fun={$this->Condicao['id_aten_fun']}&atendimento={$this->Condicao['adms_atendimento_id']}&atividade={$this->Condicao['adms_atividade_id']}");

        if ($update->getResultado()) {
            //die();
            // Passando para o atributo Atividade o status = true, registro realizado com sucesso
            //Permitir para prioridade 1 pois reordenará as atividades do antigo funcionario
            if ($this->FuncionarioId != $this->Condicao['adms_funcionario_id_ant'] && $this->ordemRetirada < $this->ultimaOrdem) {
                //die();
                $reordenar->reordenarAtv();
            }
            return 1;
        } else {
            // Passando para o atributo Atividade o status = false, registro realizado não foi realizado
            return 0;
        }
    }

}
