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

class BuscarDuracaoAtividades
{
    private $FuncionarioId;
    private $Data;
    private $Atividade;

    public function __construct($FuncionarioId, $Data = null)
    {
        $this->FuncionarioId = (int) $FuncionarioId;
        $this->Data = date('Y-m-d', strtotime($Data));

        $this->buscar();
    }

    /*
     * Buscar duração das atividades do funcionário na data especifica
     */
    private function buscar()
    {
        $query = new AdmsRead();
        $query->fullRead("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duracao_atividade)))  AS duracao_atividade, SUM(TIME_TO_SEC(duracao_atividade))  AS duracao_atividade_sc
                                FROM adms_atendimento_funcionarios
                                WHERE adms_funcionario_id =:id
                                AND data_inicio_planejado =:data_plan
                                AND adms_sits_atendimentos_funcionario_id NOT IN (4, 5)", "id={$this->FuncionarioId}&data_plan={$this->Data}");
        if ($query->getResultado()) {
            $this->Atividade = $query->getResultado()[0];
            $this->Atividade['status'] = true;
        } else {
            $this->Atividade['status'] = false;
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