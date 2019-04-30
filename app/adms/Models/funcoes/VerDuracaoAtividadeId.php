<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 30/04/2019
 * Time: 12:15
 */

namespace App\adms\Models\funcoes;

use App\adms\Models\helper\AdmsRead;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerDuracaoAtividadeId
{

    private $AtividadeId;
    private $Data;
    private $Atividade;

    public function __construct($AtividadeId)
    {
        $this->AtividadeId = (int) $AtividadeId;

        $this->buscar();
    }

    /*
     * Buscar duração das atividades do funcionário na data especifica
     */
    private function buscar()
    {
        $query = new AdmsRead();
        $query->fullRead("SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(duracao)))  AS duracao_atividade_id, SUM(TIME_TO_SEC(duracao))  AS duracao_atividade_sc_id
                                FROM adms_atividades
                                WHERE id = :atividade_id
                                LIMIT :limit", "atividade_id={$this->AtividadeId}&limit=1");
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