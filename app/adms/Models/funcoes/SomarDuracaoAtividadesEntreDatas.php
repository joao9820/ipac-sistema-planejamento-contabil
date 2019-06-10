<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 29/04/2019
 * Time: 16:53
 */

namespace App\adms\Models\funcoes;


use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class SomarDuracaoAtividadesEntreDatas
{
    private $FuncionarioId;
    private $DataInicio;
    private $DataFim;
    private $Atividade;

    public function __construct($FuncionarioId, $DataInicio = null, $DataFim = null)
    {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->DataInicio = date('Y-m-d', strtotime($DataInicio));
        $this->DataFim = date('Y-m-d', strtotime($DataFim));

        $this->buscar();
    }

    /*
     * Buscar duração das atividades do funcionário na data especifica
     */
    private function buscar()
    {
        $query = new AdmsRead();
        $query->fullRead("SELECT SUM(TIME_TO_SEC(alocacao_atividade))  AS duracao_atividade_sc
                                FROM adms_atendimento_funcionarios
                                WHERE adms_funcionario_id =:id
                                AND data_inicio_planejado >=:data_inicio
                                AND data_inicio_planejado <=:data_fim
                                AND adms_sits_atendimentos_funcionario_id =:sit_atividade", "id={$this->FuncionarioId}&data_inicio={$this->DataInicio}&data_fim={$this->DataFim}&sit_atividade=4");
        if ($query->getResultado()) {

            $this->Atividade = $query->getResultado()[0];
            $this->Atividade['duracao_atividade_sc'] = (int) $this->Atividade['duracao_atividade_sc'];

        } else {
            $this->Atividade = false;
        }
    }

    /*
     * Retorna array contendo dados e status
     */
    public function getDuracaoAtividade()
    {
        return $this->Atividade;
    }

}