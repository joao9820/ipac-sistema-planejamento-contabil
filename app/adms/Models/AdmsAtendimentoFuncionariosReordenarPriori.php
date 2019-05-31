<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\adms\Models;

/**
 * Description of AdmsAtendimentoFuncionariosReordenarPriori
 *
 * @author joao.victor
 */
use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use DateTime;
use App\adms\Models\funcoes\Funcoes;

class AdmsAtendimentoFuncionariosReordenarPriori {

    private $FuncId;
    private $dataAtual;
    private $ordem;
    private $horaInicio;
    private $horaAtual;
    private $inicioReordem;
    private $DadosOrd;
    private $ordemAtual;
    private $dataInicio;
    private $Resultado;
    private $atenFuncId;
    private $novaData;
    private $tempoExcedido;
    private $horaInicioFunc;
    private $duracaoAtv;
    private $aux;

    function getResultado() {
        return $this->Resultado;
    }

    public function reordenarAtvPriori($ordem, $func_id, $duracao_atv, $data_inicio, $hora_inicio) {
        $reordenar = new AdmsRead(); //Encontrará todas as ordens para acrescentar 1 a partir de uma condição

        $this->FuncId = $func_id;
        $this->duracaoAtv = $duracao_atv;
        $this->horaInicio = $hora_inicio;
        $this->horaAtual = date('H:i:s');
        $this->dataInicio = $data_inicio;
        $this->dataAtual = date('Y-m-d');

        //$this->buscarUltOrdemAtvFunc();
        //$ordem_max = $this->getResultado()[0]['ordem'];
        //Lógica atual trocar ordem dos 
        //$updateOrdem = new \App\adms\Models\helper\AdmsUpdate();

        echo '<br/>' . $this->duracaoAtv;

        $this->ordem = $ordem; //Menor ordem disponível


        var_dump($ordem);

        $this->buscarMinOrdemDataPriori();

        if (!empty($this->inicioReordem)) {
            $this->ordem = $this->inicioReordem[0]['ordem']; //Ordem a partir do horário disponovel
        }


        //$this->buscarUltOrdemAtvFunc();
        //Adicionar este update após o foreach
        //$updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->ordem, "WHERE ordem = :ordem_ant AND adms_funcionario_id = :adms_funcionario_id ", "ordem_ant={$ordem_max}&adms_funcionario_id={$this->FuncId}");
        //die();

        $reordenar->fullRead("SELECT id,ordem, data_inicio_planejado, hora_inicio_planejado FROM adms_atendimento_funcionarios 
                WHERE adms_funcionario_id =:adms_funcionario_id
                AND ordem >= :ordem
                ORDER BY ordem", "adms_funcionario_id={$this->FuncId}&ordem={$this->ordem}");

        $resultadoBD = $reordenar->getResultado();

        var_dump($resultadoBD);
        //die();
        //die();
        /*
          $this->dataAtual = date('Y-m-d');
          $this->horaAtual = date('H:i:s');

          $diferencaHoras = new Funcoes();
          $horaAtual = $diferencaHoras->hora_to_segundos($this->horaAtual);
          $horaInicio = $diferencaHoras->hora_to_segundos($this->horaInicio);

          if((($this->dataOrdemPriori == $this->dataAtual) && ($horaAtual > $horaInicio))){ //Se não continuará com a hora atribuida anteriormente
          $this->horaInicio = $this->horaAtual;
          }
         */
        
        var_dump($this->inicioReordem);
        //die();

        //$somarHoras = new Funcoes();
        //$this->horaInicio = $somarHoras->somar_time_in_hours($this->duracaoAtv, $this->horaInicio);
        if (!empty($this->inicioReordem)) {
            //die();

            $reordemHoraInicio = $this->inicioReordem[0]['hora_inicio_planejado']; //O primeiro inicia pela hora do inicio da atv apagada, porém os outros irão sempre pegar da hora final do anterior
            $ordemHorainicio = (int) $this->inicioReordem[0]['ordem'];

            $updateOrdem = new \App\adms\Models\helper\AdmsUpdate();

            foreach ($resultadoBD as $novaOrdem) {

                //while($novaOrdem['ordem'])

                $novaOrdem['ordem'] = (int) $novaOrdem['ordem'];
                $this->DadosOrd['ordem'] = $novaOrdem['ordem'] + 1; //Os valores que serão atualizados estão neste atributo

                $this->ordemAtual = $novaOrdem['ordem'];

                $this->idOrdem = $novaOrdem['id'];

                echo 'ORDEM ATUAL BD: ' . $this->ordemAtual;
                //die();
                //Se a data for a mesma altera a ordem e o horário, caso não seja altera so o horário

                if ($this->ordemAtual >= $ordemHorainicio) { //Quer dizer que há ordens depois da hora/data desta atividade                
                    if ($this->ordemAtual == $ordemHorainicio) { //4
                        $somarHoras = new Funcoes();
                        
                        echo '<br>Duração da Atv que vai ser atribuida: ' . $this->duracaoAtv;
                        
                        $this->horaInicio = $somarHoras->somar_time_in_hours($this->duracaoAtv, $reordemHoraInicio); //Hora definida para atividade antiga
                        /*

                          $diferencaHoras = new Funcoes();
                          $horaAtual = $diferencaHoras->hora_to_segundos($this->horaAtual);
                          $horaInicio = $diferencaHoras->hora_to_segundos($this->horaInicio);

                          if($horaAtual > $horaInicio){ //Se não continuará com a hora atribuida anteriormente
                          $this->horaInicio = $this->horaAtual;
                          }
                         */
                        $this->DadosOrd['hora_inicio_planejado'] = $this->horaInicio; //13:53 

                        $reordemHoraInicio = $this->DadosOrd['hora_inicio_planejado'];
                        echo '<br>Entrou agora: ' . $this->ordemAtual . ' ' . $this->DadosOrd['hora_inicio_planejado'] . '<br>';
                        //die();
                    } else {
                        $this->DadosOrd['hora_inicio_planejado'] = $reordemHoraInicio;
                    }

                    $this->anulaOrdemIgual();
                    
                    //echo 'Duracao atual: ' . $this->aux;
                    //será a hora que vai ser atualizada nesta ordem       

                    $reordemDia = new \App\adms\Models\AdmsReordenarData();

                    echo '<br/>Data anterior: ' . $this->dataInicio . ' Reordem hora inicio : ' . $reordemHoraInicio;

                    $reordemDia->defineData($this->FuncId, $this->dataInicio, $reordemHoraInicio); //30/04

                    $this->novaData = $reordemDia->getDefineData()['nova_data'];


                    $this->retornaOrdemAnulada();
                    //die();
                    echo '<br/>Nova Data: ' . $this->novaData .' ' . $this->duracaoAtv.'<br>';
                    //die();

                    if ($this->novaData != $this->dataInicio) { //Se sim significa que a data de inicio mudou e consequentemente a hora também, o tempo excedeu
                        $this->DadosOrd['data_inicio_planejado'] = $this->novaData;

                        echo 'Entrou para verificar nova data na ordem' . $this->ordemAtual . 'HOrainicio: ' .$this->DadosOrd['hora_inicio_planejado'] .'<br>';

                        $this->tempoExcedido = $reordemDia->getDefineData()['tempo_excedido'];

                        //Verifica se existe atividade pra esse dia (Talvez não seja mais necessário, pois na nova lógica entrará apenas somando 1 dia que deve começar sem atividade, será a 1º)
                        $reordemDia->verificarExisteAtividade($this->novaData);

                        $this->dataInicio = $this->novaData; //Pois a data de compração fica sendo esta e só entrará nessa condição novamente se o dia mudar

                        $inicioAti = new AdmsRead();
                        $inicioAti->fullRead("SELECT hora_inicio 
                    FROM adms_planejamento 
                    WHERE adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "adms_funcionario_id={$this->FuncId}&limit=1");

                        if ($inicioAti->getResultado()) { //Se for vdd fullread
                            $this->horaInicioFunc = $inicioAti->getResultado();
                            // Pegar o tempo excedito da atividade do dia anterior e somar com a hora de inicio planejado do juncionario para o proximo dia
                            $partes = explode(':', $this->horaInicioFunc[0]['hora_inicio']);

                            $segundosAtividades = $partes[0] * 3600 + $partes[1] * 60 + $partes[2];
                            $resultado = $segundosAtividades + $this->tempoExcedido; // Pegando o tempo excedido e somando com a hora de inicio

                            echo 'Tempo Excedido em Reordenar: ' . $this->tempoExcedido;

                            $this->DadosOrd['hora_inicio_planejado'] = gmdate("H:i:s", $resultado); //08:10
                           // $this->buscarDuracaoAtvReordem(); //Atribui a duracao da atv

                            $hora_fim = new Funcoes();
                            $this->DadosOrd['hora_fim_planejado'] = $hora_fim->somar_time_in_hours($this->duracaoAtv, $this->DadosOrd['hora_inicio_planejado']); //Hora fim = hora de inicio com o excedente
                            $reordemDia->buscarUltimaAtiviFuncAlmoco($this->DadosOrd['hora_fim_planejado'], $this->DadosOrd['data_inicio_planejado'], $this->duracaoAtv, $this->DadosOrd['hora_inicio_planejado'], $this->tempoExcedido); //Validação

                            if ($reordemDia->getBuscarUltimaAtiviFuncAlmoco() != FALSE) { //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
                                $this->DadosOrd['hora_inicio_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio'];
                                $this->DadosOrd['hora_fim_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
                            }

                            $reordemHoraInicio = $this->DadosOrd['hora_fim_planejado'];
                        }
                    } else {

                        //$this->buscarDuracaoAtvReordem(); //Atribui a duracao da atv
                        echo '<br>Duracao de cada atividade: ' . $this->duracaoAtv . '<br>';
                        $hora_fim = new Funcoes();
                        $this->DadosOrd['hora_fim_planejado'] = $hora_fim->somar_time_in_hours($this->duracaoAtv, $this->DadosOrd['hora_inicio_planejado']);

                        $this->DadosOrd['data_inicio_planejado'] = $this->dataInicio;

                        $reordemDia->buscarUltimaAtiviFuncAlmoco($this->DadosOrd['hora_fim_planejado'], $this->DadosOrd['data_inicio_planejado'], $this->duracaoAtv); //Validação

                        if ($reordemDia->getBuscarUltimaAtiviFuncAlmoco() != FALSE) { //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
                            $this->DadosOrd['hora_inicio_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio'];
                            $this->DadosOrd['hora_fim_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
                        }

                        $reordemHoraInicio = $this->DadosOrd['hora_fim_planejado'];

                        //echo 'Print_r: <br/>';
                        //print_r($this->DadosOrd);
                        //die();
                    }
                }

                //$this->atualizarHoraAtv(); //Passa a ordem que está no momento
                // $this->DadosOrd['hora_fim_planejado'] = $this->Dados['hora_fim_planejado'];
                //var_dump($this->DadosOrd);
                print_r($this->DadosOrd);
                echo "<br><br>";
                //echo 'Acabou na ordem: ' . $this->ordemAtual;

                $updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->DadosOrd, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$novaOrdem['ordem']}&ordemId={$novaOrdem['id']}");

                //die();
                //Obs: A coluna terá um apelido gerado como ordem (posição do array) portanto o link referente a outro valor não pode ter nome igual  
            }
        } else {

            $updateOrdem = new \App\adms\Models\helper\AdmsUpdate();

            foreach ($resultadoBD as $novaOrdem) {

                $novaOrdem['ordem'] = (int) $novaOrdem['ordem'];
                $this->DadosOrd['ordem'] = $novaOrdem['ordem'] + 1; //Os valores que serão atualizados estão neste atributo

                echo 'Ordem apenas: ' . $novaOrdem['ordem'];
                echo '<br>Agora é: ' . $this->DadosOrd['ordem'];

                $updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->DadosOrd, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$novaOrdem['ordem']}&ordemId={$novaOrdem['id']}");
            }
        }
       //die();
    }

    private function atualizarHoraAtv() {

        //Buscar a duração da próxima atividade em relação a que foi apagada

        $reordemDuracao = $this->buscarDuracaoAtvReordem();

        //Colocar essa estrutura em um loop, definindo apenas a hora de inicio da atividade atualizada
        //Soma as horas e minutos da duração da atividade com a hora_inicio_planejado para saber quando ela irá terminar
        $help = explode(':', $reordemDuracao[0]['duracao_atividade']);
        $data = new DateTime(date('H:i', strtotime($this->DadosOrd['hora_inicio_planejado'])));
        $data->modify('+' . $help[0] . ' hours');
        $data->modify('+' . $help[1] . ' minutes');
        $somaHoraInicio = $data->format('H:i'); //soma a hora de inicio mais a duracao e define a hora do fim da atv
        $this->Dados['hora_fim_planejado'] = date('H:i:s', strtotime($somaHoraInicio));
    }

    private function buscarDuracaoAtvReordem() {

        $buscarDuracaoAtv = new AdmsRead();
        $buscarDuracaoAtv->fullRead("
            SELECT duracao_atividade, data_inicio_planejado
            FROM adms_atendimento_funcionarios
            WHERE adms_funcionario_id =:adms_funcionario_id 
            AND ordem = :ordem AND id = :id LIMIT :limit", "ordem={$this->ordemAtual}&id={$this->idOrdem}&adms_funcionario_id={$this->FuncId}&limit=1"
        );

        $duracaoAtv = $buscarDuracaoAtv->getResultado();
        $this->duracaoAtv = $duracaoAtv[0]['duracao_atividade'];
        //var_dump($duracaoTotalAtv);
        //die();
    }

    public function buscarOrdem($func_i = NULL) { //Busca a ordem que está sendo apagada ou em relação ao id, atualizada
        if (!empty($func_i)) {

            $this->atenFuncId = $func_i;
        }

        echo $this->atenFuncId;

        $listar = new AdmsRead();

        //Busca a ordem da atividade a ser apagada
        $listar->fullRead("SELECT hora_inicio_planejado, ordem, data_inicio_planejado FROM adms_atendimento_funcionarios
                WHERE id = :id", "id={$this->atenFuncId}");

        $ordem = $listar->getResultado();

        $ordemApagada = (int) $ordem[0]['ordem'];
        $horaInicioOrdemApagada = $ordem[0]['hora_inicio_planejado'];

        $this->ordem = $ordemApagada;
        $this->horaInicio = $horaInicioOrdemApagada;
        $this->dataInicio = $ordem[0]['data_inicio_planejado'];
        //die();
    }

    public function buscarUltOrdemAtvFunc($id_func = NULL) {
        //Quando vier por parâmetro salvamos esse func_id para atualizar as ordens e o planejamento, senão será só pra inserção da ordem na hora do registro, sem necessidade de salvar

        if (!empty($id_func)) { //Pelo apagar passa o id pois não chama o inserirOrdem apenas busca inserir a ordem
            $this->FuncId = $id_func;
        }

        $ordemAtv = new AdmsRead();
        $ordemAtv->fullRead("SELECT MAX(ordem) as ordem
        FROM adms_atendimento_funcionarios 
        WHERE adms_funcionario_id=:adms_funcionario_id LIMIT :limit", "adms_funcionario_id={$this->FuncId}&limit=1");

        $this->Resultado = $ordemAtv->getResultado();
    }

    private function buscarMinOrdemDataPriori($Data = null) { //Busca a menor ordem que possua a mesma data ou superior a data da atividade que está sendo editada com prioridade
        
        if(!empty($Data)){
            $this->dataInicio = $Data;
            //echo $this->dataInicio;
        }
        
        $minOrdem = new AdmsRead();
//echo $this->dataInicio;
        if ($this->dataInicio == $this->dataAtual) {
            //echo 'entrou aqui';
            $minOrdem->fullRead("SELECT ordem, hora_inicio_planejado, data_inicio_planejado  
                             FROM adms_atendimento_funcionarios 
                             WHERE ordem = (SELECT MIN(ordem) 
                             FROM adms_atendimento_funcionarios 
                             WHERE adms_funcionario_id = :adms_funcionario_id AND data_inicio_planejado = :data_inicio_planejado AND hora_inicio_planejado >= :hora_inicio_planejado AND ordem >= :ordem AND prioridade > :prioridade)
                             AND adms_funcionario_id = :adms_funcionario_id", "adms_funcionario_id={$this->FuncId}&data_inicio_planejado={$this->dataInicio}&hora_inicio_planejado={$this->horaAtual}&ordem={$this->ordem['ordem']}&prioridade=1");

            if ($minOrdem->getResultado()) {
                $this->inicioReordem = $minOrdem->getResultado();
            }else{ //Se for nulo quer dizer que há atividades com o horario menor que o atual nesse mesmo dia por isso buscará no próximo
                $somaDia = new Funcoes();
                //$somaDia->dia_in_data($Data, 1, "+");
                //echo 'entrou' . $Data;
                $this->dataInicio = $somaDia->dia_in_data($this->dataInicio, 1, "+");
                
                $novaData = new AdmsReordenarData();
                $Data = $novaData->verificarData($this->dataInicio); //Verificar se é fds ou feriado
                
                $this->buscarMinOrdemDataPriori($Data); //Função recursiva
            }
        } else {
            //echo 'entrou aqui outro';
            $minOrdem->fullRead("SELECT ordem, hora_inicio_planejado, data_inicio_planejado  
                             FROM adms_atendimento_funcionarios 
                             WHERE ordem = (SELECT MIN(ordem) 
                             FROM adms_atendimento_funcionarios 
                             WHERE adms_funcionario_id = :adms_funcionario_id AND data_inicio_planejado >= :data_inicio_planejado AND ordem >= :ordem AND prioridade > :prioridade)
                             AND adms_funcionario_id = :adms_funcionario_id", "adms_funcionario_id={$this->FuncId}&data_inicio_planejado={$this->dataInicio}&ordem={$this->ordem['ordem']}&prioridade=1");
        }

        if ($minOrdem->getResultado()) {
            $this->inicioReordem = $minOrdem->getResultado();
        }
    }

    public function getbuscarMinOrdemDataPriori() {
        if ($this->inicioReordem) {
            return $this->inicioReordem[0];
        } else {
            return FALSE;
        }
    }

    private function anulaOrdemIgual() {

        $this->buscarDuracaoAtvReordem();
        $this->aux = $this->duracaoAtv;
        $vetor['duracao_atividade'] = NULL;

        $anularOrdem = new \App\adms\Models\helper\AdmsUpdate();
        
        if($this->ordemAtual > $this->inicioReordem[0]['ordem']){
            //echo $this->ordemAtual . ' > ' . $this->inicioReordem[0]['ordem'];
            $anularOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id <> :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");          
        }else{  
            $anularOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");
        }
        
    }

    private function retornaOrdemAnulada() {

        $retornaOrdem = new \App\adms\Models\helper\AdmsUpdate();

        $vetor['duracao_atividade'] = $this->duracaoAtv;
        if($this->ordemAtual > $this->inicioReordem[0]['ordem']){
            $retornaOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id <> :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");
        }else{
             $retornaOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");
        }
    }

}
