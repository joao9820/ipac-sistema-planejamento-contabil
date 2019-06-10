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
    private $ultimaOrdem;
    private $ordemEditada;
    private $horaInicio;
    private $horaAtual;
    private $inicioReordem;
    private $Dados;
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
    private $status;
    private $query;
    private $ini_reordem;

    function getResultado() {
        return $this->Resultado;
    }

    public function reordenarAtvPriori($ordem, $func_id, $duracao_atv, $data_inicio, $hora_inicio, $func_ant_id, $aten_func_id) {
        $reordenar = new AdmsRead(); //Encontrará todas as ordens para acrescentar 1 a partir de uma condição

        $this->FuncId = $func_id;
        $this->FuncIdAnt = $func_ant_id;
        $this->atenFuncId = $aten_func_id;
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

        $this->status = $this->buscarMinOrdemDataPriori();       
        //var_dump($this->status);
        //die();
        if (!empty($this->inicioReordem)) { //valor retornado aqui TRUE = 1 porém se o inicioReordem estiver com valor ja entrará aqui e não passará pela próxima condição semelhante (retorno apenas para sair da recursividade)
            $this->ordem = $this->inicioReordem[0]['ordem']; //Ordem a partir do horário disponivel
        }else if ($this->status == 1 || $this->status == 2){
            //'entrou no status 1';          
            return $this->status;
        }
        //die();

        //$this->buscarUltOrdemAtvFunc();
        //Adicionar este update após o foreach
        //$updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->ordem, "WHERE ordem = :ordem_ant AND adms_funcionario_id = :adms_funcionario_id ", "ordem_ant={$ordem_max}&adms_funcionario_id={$this->FuncId}");
        //die();
        
        
        $this->query .= "SELECT id ,ordem, data_inicio_planejado, hora_inicio_planejado FROM adms_atendimento_funcionarios 
                WHERE adms_funcionario_id = :adms_funcionario_id
                AND ordem >= :ordem ";
        
        if($this->FuncId == $this->FuncIdAnt){
            //die();
            $this->query .= "AND id <> :id ORDER BY ordem";
            echo $this->query;
            //die();
            $reordenar->fullRead($this->query,"adms_funcionario_id={$this->FuncId}&ordem={$this->ordem}&id={$this->atenFuncId}"); //ORDEM QUE SERÁ ATUALIZADA
  
            $ordens = new \App\adms\Models\AdmsAtendimentoFuncionariosReordenar(); //Independente da prioridade o planejamento do funcionário antigo sempre será reordenado o que muda é a inserção da ordem

            $ordens->buscarUltOrdemAtvFunc($this->FuncId); //Retorna a ordem e atribui o id do funcinario na classe         
            $this->ultimaOrdem = (int) $ordens->getResultado()[0]['ordem'];

            $ordens->buscarOrdem($this->atenFuncId); //Verificar se há necessidade de reordenar as atividades e o planejamento
            $this->ordemEditada = $ordens->getResultado();
            
            //echo 'Ordem Trazida: ' . $this->ordem . ' & ordem editada: ' . $this->ordemEditada; 
            //die();
            if($this->ordem > $this->ordemEditada){
                return 0;
            }

            //$this->ordemEditada = $this->ordemEditada; 
           
        }else{
             $this->query.= "ORDER BY ordem";
             $reordenar->fullRead($this->query,"adms_funcionario_id={$this->FuncId}&ordem={$this->ordem}");
        }

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
                
                        
                if($this->FuncId == $this->FuncIdAnt && $this->ordemEditada < $this->ultimaOrdem && $novaOrdem['ordem'] >= $this->ordemEditada){
                    //die();
                    $this->DadosOrd['ordem'] = (int) $novaOrdem['ordem'];
                } else {
                    $novaOrdem['ordem'] = (int) $novaOrdem['ordem'];
                    $this->DadosOrd['ordem'] = $novaOrdem['ordem'] + 1; //Os valores que serão atualizados estão neste atributo
                }
          
                /*
                $novaOrdem['ordem'] = (int) $novaOrdem['ordem'];
                $this->DadosOrd['ordem'] = $novaOrdem['ordem'] + 1; //Os valores que serão atualizados estão neste atributo
*/
                $this->ordemAtual = $novaOrdem['ordem'];

                $this->idOrdem = $novaOrdem['id'];

                echo 'ORDEM ATUAL BD: ' . $this->ordemAtual;
                //die();
                //Se a data for a mesma altera a ordem e o horário, caso não seja altera so o horário

                if ($this->ordemAtual >= $ordemHorainicio) { //Quer dizer que há ordens depois da hora/data desta atividade                
                    if ($this->ordemAtual == $ordemHorainicio) { //4
                        $somarHoras = new Funcoes();
                        
                        //echo 'HORA INICIAL DA PROXIMA ATV' . $reordemHoraInicio;
                        
                        $this->horaInicio = $somarHoras->somar_time_in_hours($this->duracaoAtv, $reordemHoraInicio); //Hora definida para atividade antiga (VERIFICAR SE ESTE HORÁRIO NÃO EXTRAPOLA A JORNADA)
                        
                        //VERIFICAR SE TEVE HORARIO DE ALMOÇO ANTES TAMBÉM (08:22 - 18:22 - duracao 10:00:00)
                        $verificaAlmoco1 = new AdmsReordenarData(); //VERIFICA HORA DE ALMOÇO PARA A ATIVIDADE COM PRIORIDADE (SEMPRE IRÁ TRAZER A HORA DE INICIO PORTANTO NUNCA PASSARÁ DA HORA_FIM_2)

                        $verificaAlmoco1->buscarUltimaAtiviFuncAlmoco($this->horaInicio, $this->dataInicio, $this->duracaoAtv, $reordemHoraInicio, NULL, $this->FuncId); //Hora de almoço no primeiro
                        
                        if($verificaAlmoco1->getBuscarUltimaAtiviFuncAlmoco()){ //Senão continua com o mesmo valor de antes em $somarHoras
                            $this->horaInicio = $verificaAlmoco1->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
                        }
                                               
                        echo '<br>Duração da Atv que vai ser atribuida: ' . $this->duracaoAtv . ' ' . $this->horaInicio . '<br>';

                      //die();

                        $verificarDia = new AdmsReordenarData();

                        $verificarDia->defineData($this->FuncId, $this->dataInicio, $this->horaInicio); //Para a atividade prioridade
                        
                        
                        //$this->horaInicio = $verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
                        
                        echo $this->horaInicio;
                        
                        if (!empty($verificarDia->getDefineData()['tempo_excedido'])) {
                            $this->tempoExcedido = $verificarDia->getDefineData()['tempo_excedido']; //VERIFICAR SE EXISTE TEMPO EXCEDIDO
                            
                            $this->tempoExcedido = $somarHoras->segundos_to_hora($this->tempoExcedido);
                            echo 'Tempo excedido: ' . $this->tempoExcedido;
                            //die();
                            
                            $hora_inicio_priori2 = $verificarDia->getHoraInicio()['hora_inicio'];
                            
                            /*
                            if($reordemHoraInicio < $hora_inicio_priori2){
                                
                            }
                            */
                            $hora_termino2 = $verificarDia->getHoraInicio()['hora_termino2'];
                            
                            //echo 'HORA DE INICIO: ' . $hora_termino2;
                            
                            //$this->atvTempoRealizado = $somarHoras->sbtrair_horas_in_hours($hora_termino2, $reordemHoraInicio);
                            //echo '<br>Atv tempo realizado ' . $this->atvTempoRealizado;
                            
                            //$this->atvTempoRealizado = $somarHoras->sbtrair_horas_in_hours($this->duracaoAtv, $this->atvTempoRealizado);

                            $hora_fim_priori2 = $somarHoras->somar_time_in_hours($hora_inicio_priori2, $this->tempoExcedido); //09:22
                            
                            //$hora_fim_priori2 = $somarHoras->somar_time_in_hours($hora_fim_priori2, $this->tempoExcedido);
                           
                            echo '<br>HORA_FIM_PRIORI_2: ' . $hora_fim_priori2;
                            
                            //die();
                            
                            echo '<br>TEMPO EXCEDIDO DA ATIVIDADE COM PRIORIDADE: ' . $this->tempoExcedido;

                            //die();

                            $verificaAlmoco = new AdmsReordenarData(); //VERIFICA HORA DE ALMOÇO PARA A ATIVIDADE COM PRIORIDADE (SEMPRE IRÁ TRAZER A HORA DE INICIO PORTANTO NUNCA PASSARÁ DA HORA_FIM_2)

                            $verificaAlmoco->buscarUltimaAtiviFuncAlmoco($hora_fim_priori2, $this->dataInicio, $this->tempoExcedido, $hora_inicio_priori2, NULL, $this->FuncId);

                            //$verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco();

                            if ($verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco() != FALSE) { //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
                                //die();
                                $this->Dados['hora_inicio_planejado'] = $reordemHoraInicio;//$verificaAlmoco->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio']
                                $this->Dados['hora_fim_planejado'] = $this->horaInicio;
                                echo 'TESTE:' . $this->Dados['hora_fim_planejado'];
                            } else { //Mantém os valores anteriores (ENTRAVA AQUI)
                                //die();
                                $this->Dados['hora_inicio_planejado'] = $reordemHoraInicio;
                                $this->Dados['hora_fim_planejado'] = $this->horaInicio;
                            }
                        } else { //SE NÃO TIVER EXCEDENTE SERÁ NO MESMO DIA, PORTANTO SÓ VERIFICAMOS O ALMOÇO
                            
                                $this->Dados['hora_inicio_planejado'] = $reordemHoraInicio;
                                $this->Dados['hora_fim_planejado'] = $this->horaInicio;             
                        }

                        /*
                          $diferencaHoras = new Funcoes();
                          $horaAtual = $diferencaHoras->hora_to_segundos($this->horaAtual);
                          $horaInicio = $diferencaHoras->hora_to_segundos($this->horaInicio);

                          if($horaAtual > $horaInicio){ //Se não continuará com a hora atribuida anteriormente
                          $this->horaInicio = $this->horaAtual;
                          }
                         */
                        
                        
                        echo '<br>Hora inicio da prox ' . $this->Dados['hora_fim_planejado'];
                        $this->DadosOrd['hora_inicio_planejado'] = $this->Dados['hora_fim_planejado']; //13:53 focar aqui

                        $reordemHoraInicio = $this->DadosOrd['hora_inicio_planejado'];
                        echo '<br>Entrou agora: ' . $this->ordemAtual . ' ' . $this->DadosOrd['hora_inicio_planejado'] . '<br>';
                        
                        //die();
                        
                    } else {
                        $this->DadosOrd['hora_inicio_planejado'] = $reordemHoraInicio;
                    }

                    //$this->anulaOrdemIgual();
                    //$this->DadosOrd['duracao_atividade'] = $this->duracaoAtv;
                    //echo 'Duracao atual: ' . $this->aux;
                    //será a hora que vai ser atualizada nesta ordem       

                    $reordemDia = new \App\adms\Models\AdmsReordenarData();

                    echo '<br/>Data anterior: ' . $this->dataInicio . ' Reordem hora inicio : ' . $reordemHoraInicio;
                    //die();
                    $reordemDia->defineData($this->FuncId, $this->dataInicio, $reordemHoraInicio); //30/04

                    $this->novaData = $reordemDia->getDefineData()['nova_data'];

                    $this->buscarDuracaoAtvReordem();
                    //$this->retornaOrdemAnulada();
                    //die();
                    echo '<br/>Nova Data: ' . $this->novaData . ' ' . $this->duracaoAtv . '<br>';
                    //die();

                    if ($this->novaData != $this->dataInicio) { //Se sim significa que a data de inicio mudou e consequentemente a hora também, o tempo excedeu
                        $this->DadosOrd['data_inicio_planejado'] = $this->novaData;

                        echo 'Entrou para verificar nova data na ordem' . $this->ordemAtual . 'HOrainicio: ' . $this->DadosOrd['hora_inicio_planejado'] . '<br>';

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
                            //$this->buscarDuracaoAtvReordem(); //Atribui a duracao da atv

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
                //die();
                //echo 'Acabou na ordem: ' . $this->ordemAtual;
                /*
                  $this->DadosOrd['data_inicio_planejado'] = '2019-07-22';
                  if($this->ordemAtual == 6){
                  $this->DadosOrd['data_inicio_planejado'] = '2019-07-23';
                  } */
                
                
                $updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->DadosOrd, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$novaOrdem['ordem']}&ordemId={$novaOrdem['id']}");
                /*
                  if($this->ordemAtual == 6){
                  die();
                  } */


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
        
        //return TRUE;
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
        /* if($this->ordemAtual > $this->inicioReordem[0]['ordem']){
          $buscarDuracaoAtv = new AdmsRead();
          $buscarDuracaoAtv->fullRead("
          SELECT duracao_atividade, data_inicio_planejado
          FROM adms_atendimento_funcionarios
          WHERE adms_funcionario_id =:adms_funcionario_id
          AND ordem = :ordem AND id <> :id LIMIT :limit", "ordem={$this->ordemAtual}&id={$this->idOrdem}&adms_funcionario_id={$this->FuncId}&limit=1"
          );
          }else */
        $buscarDuracaoAtv = new AdmsRead();
        $buscarDuracaoAtv->fullRead("
                SELECT duracao_atividade, data_inicio_planejado
                FROM adms_atendimento_funcionarios
                WHERE adms_funcionario_id =:adms_funcionario_id 
                AND ordem = :ordem AND id = :id LIMIT :limit", "ordem={$this->ordemAtual}&id={$this->idOrdem}&adms_funcionario_id={$this->FuncId}&limit=1"
        );
        //}
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
        if (!empty($Data)) {
            $this->dataInicio = $Data;
            echo $this->dataInicio;
            //echo $this->buscarMinOrdemDataPriori(); aqui ainda não há valor de retorno
        }

        $minOrdem = new AdmsRead();
//echo $this->dataInicio;
        if ($this->dataInicio == $this->dataAtual) {
            //echo 'entrou aqui';
            $minOrdem->fullRead("SELECT ordem, hora_inicio_planejado, data_inicio_planejado, id  
                             FROM adms_atendimento_funcionarios 
                             WHERE ordem = (SELECT MIN(ordem) 
                             FROM adms_atendimento_funcionarios 
                             WHERE adms_funcionario_id = :adms_funcionario_id AND data_inicio_planejado = :data_inicio_planejado AND hora_inicio_planejado >= :hora_inicio_planejado AND ordem >= :ordem AND prioridade > :prioridade)
                             AND adms_funcionario_id = :adms_funcionario_id", "adms_funcionario_id={$this->FuncId}&data_inicio_planejado={$this->dataInicio}&hora_inicio_planejado={$this->horaAtual}&ordem={$this->ordem['ordem']}&prioridade=1");

            if ($minOrdem->getResultado()) {
                //echo 'parou aqui';
                //die();
                $this->ini_reordem = $minOrdem->getResultado();
            } else { //Se for nulo quer dizer que há atividades com o horario menor que o atual nesse mesmo dia por isso buscará no próximo
                $somaDia = new Funcoes();
                //$somaDia->dia_in_data($Data, 1, "+");
                //echo 'entrou' . $Data;
                $this->dataInicio = $somaDia->dia_in_data($this->dataInicio, 1, "+");

                $novaData = new AdmsReordenarData();
                $Data = $novaData->verificarData($this->dataInicio); //Verificar se é fds ou feriado

                $status = $this->buscarMinOrdemDataPriori($Data); //Função recursiva
                
                if($status == 1 || $status == 2){
                    return $status; //sai da função principal
                }else{
                    return TRUE;
                }
                //echo $this->buscarMinOrdemDataPriori(); //Está voltando para cá o valor de retorno            
            }
        } else {
            //echo 'entrou aqui outro';
            //echo $this->dataInicio;
            //die();
            $minOrdem->fullRead("SELECT ordem, hora_inicio_planejado, data_inicio_planejado, id  
                             FROM adms_atendimento_funcionarios 
                             WHERE ordem = (SELECT MIN(ordem) 
                             FROM adms_atendimento_funcionarios 
                             WHERE adms_funcionario_id = :adms_funcionario_id AND data_inicio_planejado >= :data_inicio_planejado AND ordem >= :ordem AND prioridade > :prioridade)
                             AND adms_funcionario_id = :adms_funcionario_id", "adms_funcionario_id={$this->FuncId}&data_inicio_planejado={$this->dataInicio}&ordem={$this->ordem['ordem']}&prioridade=1");
                             
                             
            $this->ini_reordem = $minOrdem->getResultado();
           
            //var_dump($inicio_reordem);
           //die();
           
        }
        /*
        if(($minOrdem->getResultado())){
            var_dump($minOrdem->getResultado());             
        }*/
        //die();
        
       //$inicio_reordem = $inicio_reordem;
        var_dump($this->ini_reordem);
             
        if ((!empty($this->ini_reordem) && $this->FuncId != $this->FuncIdAnt) || (!empty($this->ini_reordem) && $this->FuncId == $this->FuncIdAnt && $this->ini_reordem[0]['id'] != $this->atenFuncId)) {
            //echo 'valor para inicio reordem';      
            $this->inicioReordem = $this->ini_reordem; //Só reordena se entrar aqui
        }else if (empty($this->ini_reordem) && $this->FuncId != $this->FuncIdAnt){ //Quer dizer que não encontrou ordem para ser substituida pela prioridade, apenas deve inserir a atividade para o planejamento do novo funcionario na ultima ordem com prioridade 1
            echo 'entrou aqui no 1';
            var_dump($this->ini_reordem);
            //die();
            
            //die();
            
            echo 'retorna 1';
            //die();
            
            return 1;
            
        }else if((!empty($this->ini_reordem) && $this->FuncId == $this->FuncIdAnt && $this->ini_reordem[0]['id'] == $this->atenFuncId) || (empty($this->ini_reordem) && $this->FuncId == $this->FuncIdAnt)){
            //Quando se tratar do mesmo funcionário nenhuma atv será inserida ou replanejada, apenas se alterará o campo prioridade de 2 para 1 se já não tiver desta forma
            //echo 'id da busca: ' . $minOrdem->getResultado()[0]['id'];
            //echo '<br>id do atendimento: ' . $this->atenFuncId;
            
            //echo 'retorna 2<br>';
            //die();
            return 2; //Se retornar valor volta para a chamada da recursividade e passará por essas condições novamente
        }
        //echo 'foi até o final da função';
        //die();
    }

    public function getbuscarMinOrdemDataPriori() {
        if ($this->inicioReordem) {
            return $this->inicioReordem[0];
        } else {
            return FALSE;
        }
    }

    private function anulaOrdemIgual() { //Anula a ordem no outro id
        $this->buscarDuracaoAtvReordem();
        $this->aux = $this->duracaoAtv;

        echo '<br>Duração trazida na ordem ' . $this->ordemAtual . ': ' . $this->duracaoAtv . '<br>';

        $vetor['duracao_atividade'] = NULL;

        $anularOrdem = new \App\adms\Models\helper\AdmsUpdate();

        //if($this->ordemAtual > $this->inicioReordem[0]['ordem']){
        //echo $this->ordemAtual . ' > ' . $this->inicioReordem[0]['ordem'];
        //$anularOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id <> :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");          
        //}else{  
        $anularOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");
        //}
    }

    private function retornaOrdemAnulada() { //VERIFICAR DURAÇÃO QUE ESTÁ SENDO RETORNADA AQUI Retorna a ordem do outro id  que foi anulado
        $retornaOrdem = new \App\adms\Models\helper\AdmsUpdate();

        $vetor['duracao_atividade'] = $this->duracaoAtv; //Essa duração está sendo atribuída na ordem errada
        //if($this->ordemAtual > $this->inicioReordem[0]['ordem']){
        // $retornaOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id <> :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");
        //die();
        //}else{

        $retornaOrdem->exeUpdate("adms_atendimento_funcionarios", $vetor, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem AND id = :ordemId", "adms_funcionario_id={$this->FuncId}&novaOrdem={$this->ordemAtual}&ordemId={$this->idOrdem}");
        /* if($this->ordemAtual == 6){
          die();
          } */
//die();
        //}
    }

    public function getDadosAtvPriori() {
        return $dados = ['hora_inicio_planejado' => $this->Dados['hora_inicio_planejado'], 'hora_fim_planejado' => $this->Dados['hora_fim_planejado']];
    }

}
