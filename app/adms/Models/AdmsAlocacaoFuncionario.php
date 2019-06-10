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
use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class AdmsAlocacaoFuncionario
{

    private $Dados;
    private $DadosAlocacao;
    private $FuncionarioId;
    private $DataInicio;
    private $DataFim;

    public function __construct($FuncionarioId, $DataInicio = null, $DataFim = null)
    {
        $this->FuncionarioId = (int) $FuncionarioId;
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
        while ($this->DataInicio <= $this->DataFim) {

            // Query
            $this->queryBuscarAlocacao($this->FuncionarioId, $this->DataInicio);


            // Somar 1 dia a data de inicio
            $maisUmDia = new Funcoes();
            $this->DataInicio = $maisUmDia->dia_in_data($this->DataInicio, 1);
        }
    }

    /*
     * Query para buscar dados no banco e atribuir para um array
     */
    private function queryBuscarAlocacao($FuncionarioId, $Data)
    {
        // Verificar se é dia útil, se for buscar duração das atividades do dia e também a jornada de trabalho com hora extra
        $DiaUtil = new Funcoes();
        if ($DiaUtil->isDiaUtil($Data)) {

            // Buscando duração total das atividades
            $duracaoAtividades = new BuscarDuracaoAtividades($FuncionarioId, $Data, NULL, "4");
            $resultado = $duracaoAtividades->getDuracaoAtividade();
            $this->DadosAlocacao[$Data]['DuracaoAtividades'] = $resultado['duracao_atividade_sc'] ? $resultado['duracao_atividade_sc'] : 0;

            // Buscando o total da jornada na data informada
            $jornadaTrabalho = new BuscarDuracaoJornadaT($FuncionarioId, $Data);
            $resultado = $jornadaTrabalho->getDuracaoJornada();
            $this->DadosAlocacao[$Data]['JornadaTrabalho'] = $resultado['total'] ? $resultado['total'] : null;

        }
    }

}