<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 19/02/2019
 * Time: 17:20
 */

namespace App\adms\Models;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsVerLogsAtendimento
{

    private $Resultado;
    private $DadosId;

    public function verLogsAtendimento($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $verLogs = new \App\adms\Models\helper\AdmsRead();
        $verLogs->fullRead("SELECT * from 
                          adms_logs_atendimentos 
                          WHERE adms_atendimento_id =:adms_atendimento_id
                          ORDER BY created DESC ", "adms_atendimento_id={$this->DadosId}");
        $this->Resultado = $verLogs->getResultado();
        return $this->Resultado;
    }

}