<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsDelete;
use App\adms\Models\helper\AdmsRead;
use DateTime;
use App\adms\Models\funcoes\Funcoes;

/**
 * Description of AdmsAtendimentoFuncionariosReordenar
 *
 * @author joao.victor
 */
class AdmsAtendimentoFuncionariosReordenar {

    private $FuncId;
    private $dataAtual;
    private $ordem;
    private $horaInicio;
    private $DadosOrd;
    private $ordemAtual;
    private $dataOrdemApagada;
    private $Resultado;
    private $atenFuncId;
    private $novaData;
    private $tempoExcedido;
    private $horaInicioFunc;
    private $duracaoAtv;

    function getResultado() {
        return $this->Resultado;
    }

    public function reordenarAtv() {  //Os valores necessários podem vir de outros métodos
        $reordenar = new AdmsRead(); //Encontrará todas as ordens para decrementar 1 a partir de uma condição

        $reordenar->fullRead("SELECT ordem FROM adms_atendimento_funcionarios 
                WHERE adms_funcionario_id =:adms_funcionario_id
                AND ordem > :ordem
                ORDER BY ordem", "adms_funcionario_id={$this->FuncId}&ordem={$this->ordem}");

        $resultadoBD = $reordenar->getResultado();
        
        $this->dataAtual = date('Y-m-d');
        $this->horaAtual = date('H:i:s');
        
        $diferencaHoras = new Funcoes();
        $horaAtual = $diferencaHoras->hora_to_segundos($this->horaAtual);
        $horaInicio = $diferencaHoras->hora_to_segundos($this->horaInicio);
        
        if((($this->dataOrdemApagada == $this->dataAtual) && ($horaAtual > $horaInicio))){ //Se não continuará com a hora atribuida anteriormente
            $this->horaInicio = $this->horaAtual;
        }
        
        $reordemHoraInicio = $this->horaInicio; //O primeiro inicia pela hora do inicio da atv apagada, porém os outros irão sempre pegar da hora final do anterior

        //var_dump($resultadoBD);
        //echo $reordemHoraInicio;
        //die();

        $updateOrdem = new \App\adms\Models\helper\AdmsUpdate();

        foreach ($resultadoBD as $novaOrdem) {

            $novaOrdem['ordem'] = (int) $novaOrdem['ordem'];
            $this->DadosOrd['ordem'] = $novaOrdem['ordem'] - 1; //Os valores que serão atualizados estão neste atributo

            $this->ordemAtual = $novaOrdem['ordem'];

            //Se a data for a mesma altera a ordem e o horário, caso não seja altera so o horário
            
            $this->DadosOrd['hora_inicio_planejado'] = $reordemHoraInicio; //9:30

            //será a hora que vai ser atualizada nesta ordem    

            $reordemDia = new \App\adms\Models\AdmsReordenarData();

            $reordemDia->defineData($this->FuncId, $this->dataOrdemApagada, $reordemHoraInicio); //30/04

            $this->novaData = $reordemDia->getDefineData()['nova_data'];

            echo '<br/>Nova Data: ' . $this->novaData;
            //die();

            if ($this->novaData != $this->dataOrdemApagada) { //Se sim significa que a data de inicio mudou e consequentemente a hora também, o tempo excedeu
                $this->DadosOrd['data_inicio_planejado'] = $this->novaData;
                
                $this->tempoExcedido = $reordemDia->getDefineData()['tempo_excedido'];
                
                //Verifica se existe atividade pra esse dia (Talvez não seja mais necessário, pois na nova lógica entrará apenas somando 1 dia que deve começar sem atividade, será a 1º)
                $reordemDia->verificarExisteAtividade($this->novaData); 

                $this->dataOrdemApagada = $this->novaData; //Pois a data de compração fica sendo esta e só entrará nessa condição novamente se o dia mudar
                
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
                    $this->buscarDuracaoAtvReordem(); //Atribui a duracao da atv
                    
                    $hora_fim = new Funcoes();
                    $this->DadosOrd['hora_fim_planejado'] = $hora_fim->somar_time_in_hours($this->duracaoAtv, $this->DadosOrd['hora_inicio_planejado']); //Hora fim = hora de inicio com o excedente
                    $reordemDia->buscarUltimaAtiviFuncAlmoco($this->DadosOrd['hora_fim_planejado'], $this->DadosOrd['data_inicio_planejado'], $this->duracaoAtv, $this->tempoExcedido); //Validação
                    
                    if($reordemDia->getBuscarUltimaAtiviFuncAlmoco() != FALSE){ //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
                    $this->DadosOrd['hora_inicio_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio'];
                    $this->DadosOrd['hora_fim_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
                    }
                    
                    
                    $reordemHoraInicio = $this->DadosOrd['hora_fim_planejado'];
                }
                
            } else {

                $this->buscarDuracaoAtvReordem(); //Atribui a duracao da atv

                $hora_fim = new Funcoes();
                $this->DadosOrd['hora_fim_planejado'] = $hora_fim->somar_time_in_hours($this->duracaoAtv, $this->DadosOrd['hora_inicio_planejado']);
                
                $this->DadosOrd['data_inicio_planejado'] = $this->dataOrdemApagada;
                
                $reordemDia->buscarUltimaAtiviFuncAlmoco($this->DadosOrd['hora_fim_planejado'], $this->DadosOrd['data_inicio_planejado'], $this->duracaoAtv); //Validação
               
                if($reordemDia->getBuscarUltimaAtiviFuncAlmoco() != FALSE){ //Se vier algum retorno significa que houve excedente no almoço, senão continuará com os valores obtidos nesta classe
                    $this->DadosOrd['hora_inicio_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_inicio'];
                    $this->DadosOrd['hora_fim_planejado'] = $reordemDia->getBuscarUltimaAtiviFuncAlmoco()['hora_fim'];
                }
                         
                $reordemHoraInicio = $this->DadosOrd['hora_fim_planejado'];
                
                echo 'Print_r: <br/>';
                print_r($this->DadosOrd);
                //die();
            }

            //$this->atualizarHoraAtv(); //Passa a ordem que está no momento
            //$this->DadosOrd['hora_fim_planejado'] = $this->Dados['hora_fim_planejado'];

            var_dump($this->DadosOrd);

            print_r($this->DadosOrd);

            //Obs: A coluna terá um apelido gerado como ordem (posição do array) portanto o link referente a outro valor não pode ter nome igual

            $updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->DadosOrd, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem", "adms_funcionario_id={$this->FuncId}&novaOrdem={$novaOrdem['ordem']}");
        }

        //die();
        ;

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
        AND ordem = :ordem LIMIT :limit", "ordem={$this->ordemAtual}&adms_funcionario_id={$this->FuncId}&limit=1"
        );

        $duracaoAtv = $buscarDuracaoAtv->getResultado();
        $this->duracaoAtv = $duracaoAtv[0]['duracao_atividade'];
        //var_dump($duracaoTotalAtv);
        //die();
    }

    public function buscarOrdem($aten_func_id = NULL) { //Busca a ordem que está sendo apagada ou em relação ao id, atualizada
        if (!empty($aten_func_id)) {

            $this->atenFuncId = $aten_func_id;
        }

        //echo $this->atenFuncId;

        $listar = new AdmsRead();

        //Busca a ordem da atividade a ser apagada
        $listar->fullRead("SELECT hora_inicio_planejado, ordem, data_inicio_planejado FROM adms_atendimento_funcionarios
                WHERE id = :id", "id={$this->atenFuncId}");

        $ordem = $listar->getResultado();

        $ordemApagada = (int) $ordem[0]['ordem'];
        $horaInicioOrdemApagada = $ordem[0]['hora_inicio_planejado'];

        $this->ordem = $ordemApagada;
        $this->horaInicio = $horaInicioOrdemApagada;
        $this->dataOrdemApagada = $ordem[0]['data_inicio_planejado'];

        $this->Resultado = $this->ordem;

        var_dump($ordem);
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

    public function inserirOrdemAtvFunc($id_func) {

        $this->FuncId = $id_func;

        $this->buscarUltOrdemAtvFunc(); //Quando edita ou insere ordem é com o func_id atual, quando apaga ou edita planejamento é com o func_id antigo

        if ($this->Resultado != NULL) {

            $ordem = $this->Resultado;
            //var_dump($ordem[0]['ordem']);

            $this->Resultado = (int) $ordem[0]['ordem'] + 1; //Resultado desta função
        } else {
            $this->Resultado = 1;
        }
    }

}
