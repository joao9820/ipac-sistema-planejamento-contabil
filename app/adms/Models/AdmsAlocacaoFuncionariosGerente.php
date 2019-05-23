<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 20/05/2019
 * Time: 13:27
 */

namespace App\adms\Models;

use App\adms\Models\funcoes\BuscarDuracaoAtividades;
use App\adms\Models\funcoes\BuscarDuracaoJornadaT;
use App\adms\Models\funcoes\Funcoes;
use App\adms\Models\funcoes\SomarDuracaoAtividadesEntreDatas;
use App\adms\Models\funcoes\VerificarExisteHoraExtra;
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsAlocacaoFuncionariosGerente
{

    private $Dados;
    private $DadosAlocacao;
    private $GerenteId;
    private $DataInicio;
    private $DataFim;
    private $Teste;

    public function __construct($GerenteId, $DataInicio = null, $DataFim = null)
    {
        $this->GerenteId = (int) $GerenteId;
        if (empty($DataInicio)) {
            $novaData = new Funcoes();
            $this->DataInicio = date('Y-m-d');
            $this->DataFim = $novaData->dia_in_data(date('Y-m-d'),7);
        } else {
            $this->DataInicio = date('Y-m-d', strtotime($DataInicio));
            $this->DataFim = date('Y-m-d', strtotime($DataFim));
        }
        $this->lacoRepeticaoAlocacao();
    }

    /*
     * Array com os resultados
     */
    public function getDadosAlocacao()
    {
        return $this->DadosAlocacao;
    }

    /*
     * Motar estrutura de repetição para realizar consulta no banco para cada data entre a data de inicio e fim.
     */
    private function lacoRepeticaoAlocacao()
    {
        // Query para buscar todos os funcionários do gerente
        $this->buscarFuncionarios($this->GerenteId);

        foreach ($this->Dados as $key => $value) {

            // Query
            $this->queryBuscarAlocacao($value['id'], $this->DataInicio, $this->DataFim);

        }

        //var_dump($this->DadosAlocacao);
        //die;
    }

    /*
     * Query para buscar todos os funcionários ao qual o gerente é responsável
     */
    private function buscarFuncionarios($GerenteId)
    {
        // Retornar um array com todos os id dos funcionários
        $select = new AdmsRead();
        $select->fullRead("SELECT id FROM adms_usuarios WHERE gerente_id =:gerente AND adms_sits_usuario_id =:situacao","gerente={$GerenteId}&situacao=1");
        $this->Dados = $select->getResultado();
    }

    /*
     * Função para buscar dados no banco e atribuir para um array
     */
    private function queryBuscarAlocacao($FuncionarioId, $DataInicio, $DataFim)
    {
        $select = new SomarDuracaoAtividadesEntreDatas($FuncionarioId, $DataInicio, $DataFim);
        $this->DadosAlocacao[$FuncionarioId] = $select->getDuracaoAtividade();

        $this->getSomaJornadaDias($FuncionarioId, $DataInicio, $DataFim); // somar jornada de trabalho e hora extra
    }

    /*
     * Função para somar a jornada e hora extra no intervalo de dias informado
     */
    private function getSomaJornadaDias($FuncionarioId, $DataInicio, $DataFim)
    {
        $DInicio = $DataInicio;
        $DFim = $DataFim;
        $valores_jornada = 0;
        while ($DInicio <= $DFim)
        {
            $verificarHoraExtra = new VerificarExisteHoraExtra($FuncionarioId, $DInicio);
            if ($verificarHoraExtra->getResultadoHoraExtra()){
                // se existir hora extra na data especifica, então ajustar a query para somar a hora extra, se não, apenas buscar a jornada
                $select = new AdmsRead();
                $select->fullRead(
                    "SELECT TIME_TO_SEC(planejamento.jornada_trabalho) + SUM(TIME_TO_SEC(hora_extra.total)) as total
                            FROM adms_hora_extra hora_extra 
                            INNER JOIN adms_planejamento planejamento 
                            ON hora_extra.adms_usuario_id = planejamento.adms_funcionario_id
                            WHERE hora_extra.adms_usuario_id = :usuario and hora_extra.data = :data
                            GROUP BY planejamento.hora_termino2", "usuario={$FuncionarioId}&data={$DInicio}"
                );

                if($select->getResultado()) {
                    $valores_jornada += $select->getResultado()[0]['total'];
                }

            } else {

                $select = new AdmsRead();
                $select->fullRead(
                    "SELECT TIME_TO_SEC(planejamento.jornada_trabalho) as total
                            FROM adms_planejamento planejamento
                            WHERE adms_funcionario_id = :funcionario
                            GROUP BY planejamento.hora_termino2", "funcionario={$FuncionarioId}"
                );
                if($select->getResultado()) {
                    $valores_jornada += $select->getResultado()[0]['total'];
                }

            }

            // somar 1 dia a data de inicio
            $funcao = new Funcoes();
            $DInicio = $funcao->dia_in_data($DInicio, 1, "+");
        }
        $this->DadosAlocacao[$FuncionarioId]['duracao_total_jornada'] = $valores_jornada;

        // Buscar dados do funcionário
        $this->buscarDadosFuncionario($FuncionarioId);
    }

    /*
     * Buscar dados do funcionário
     */
    private function buscarDadosFuncionario($FuncionarioId)
    {
        $select = new AdmsRead();
        $select->fullRead(
            "SELECT us.id, us.nome, ca.cargo
                    FROM adms_usuarios us
                    LEFT JOIN adms_cargos ca ON ca.id = us.adms_cargo_id
                    WHERE us.id =:funcionario
                    LIMIT :limit", "funcionario={$FuncionarioId}&limit=1"
        );
        if($select->getResultado()) {
            $dados_fun = $select->getResultado()[0];
            // pegando a coluna e o valor da consulta ao banco e inserindo no array de alocação
            foreach ($dados_fun as $key => $value) {
                $this->DadosAlocacao[$FuncionarioId][$key] = $value;
            }
        }
    }

}