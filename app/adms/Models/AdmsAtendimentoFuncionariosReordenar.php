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

/**
 * Description of AdmsAtendimentoFuncionariosReordenar
 *
 * @author joao.victor
 */
class AdmsAtendimentoFuncionariosReordenar {

    private $FuncId;
    private $ordem;
    private $horaInicio;
    private $DadosOrd;
    private $ordemAtual;
    private $dataOrdemApagada;
    private $Resultado;
    private $atenFuncId;
    private $novaData;
    private $tempoExcedido;

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

        $reordemHoraInicio = $this->horaInicio; //O primeiro inicia pela hora do inicio da atv apagada, porém os outros irão sempre pegar da hora final do anterior

        var_dump($resultadoBD);
        //die();
        echo $reordemHoraInicio;
        //die();

        $updateOrdem = new \App\adms\Models\helper\AdmsUpdate();

        foreach ($resultadoBD as $novaOrdem) {

            $novaOrdem['ordem'] = (int) $novaOrdem['ordem'];
            $this->DadosOrd['ordem'] = $novaOrdem['ordem'] - 1; //Os valores que serão atualizados estão neste atributo

            $this->ordemAtual = $novaOrdem['ordem'];

            //Se a data for a mesma altera a ordem e o horário, caso não seja altera so o horário

            $this->DadosOrd['hora_inicio_planejado'] = $reordemHoraInicio;

            $this->atualizarHoraAtv(); //Passa a ordem que está no momento

            $this->DadosOrd['hora_fim_planejado'] = $this->Dados['hora_fim_planejado'];

            var_dump($this->DadosOrd);

            print_r($this->DadosOrd);

             //será a hora que vai ser atualizada nesta ordem    

            $reordemDia = new \App\adms\Models\AdmsAtendimentoFuncionarios();
            
            $reordemDia->defineData($this->FuncId, $this->dataOrdemApagada); //Verifica entre outras coisas se a hora da ultima atividade ultrapassou a jornada
            $this->tempoExcedido = $reordemDia->getDefineData()['tempo_excedido'];
            $this->novaData = $reordemDia->getDefineData()['data_inicio_planejado'];

            
        if ($this->novaData != $this->dataOrdemApagada) { //Se sim significa que a data de inicio mudou e consequentemente a hora também
                
                $this->DadosOrd['data_inicio_planejado'] = $this->novaData;
                
                $reordemDia->verificarExisteAtividade($this->FuncId, $this->novaData); //Verifica se existe atividade pra esse dia
                
                if($reordemDia->getVerificarExisteAtividade()){
                    
                    $reordemDia->buscarUltimaAtiviFunc($this->FuncId, $this->novaData);
                    $this->DadosOrd['hora_fim_planejado'] = $reordemDia->getBuscarUltimaAtiviFunc();
                    
               //fsadaees
                    
                }else{
                    
                    
                    
                }
                
                $reordemHoraInicio = $this->DadosOrd['hora_fim_planejado'];
            }else{
                
                $this->DadosOrd['data_inicio_planejado'] = $this->dataOrdemApagada;
                $reordemHoraInicio = $this->DadosOrd['hora_fim_planejado'];
                
            }

            //Obs: A coluna terá um apelido gerado como ordem (posição do array) portanto o link referente a outro valor não pode ter nome igual

            $updateOrdem->exeUpdate("adms_atendimento_funcionarios", $this->DadosOrd, "WHERE adms_funcionario_id = :adms_funcionario_id AND ordem = :novaOrdem", "adms_funcionario_id={$this->FuncId}&novaOrdem={$novaOrdem['ordem']}");
        }

        //die();
        echo 'Print_r: <br/>';
        print_r($this->DadosOrd);

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
        //var_dump($duracaoTotalAtv);
        //die();
        return $duracaoAtv;
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

        $this->buscarUltOrdemAtvFunc();

        if ($this->Resultado != NULL) {

            $ordem = $this->Resultado;
            //var_dump($ordem[0]['ordem']);

            $this->Resultado = (int) $ordem[0]['ordem'] + 1; //Resultado desta função
        } else {
            $this->Resultado = 1;
        }
    }

}
