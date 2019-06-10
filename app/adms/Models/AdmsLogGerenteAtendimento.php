<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 06/06/2019
 * Time: 12:38
 */

namespace App\adms\Models;

use App\adms\Models\helper\AdmsCreate;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AdmsLogGerenteAtendimento
{
    private $RegistrarLog;
    private $Dados;

    public function __construct($LogId, $GerenteId, $AtendimentoId, $FuncionarioId)
    {
        $this->Dados['log'] = (int) $LogId;
        $this->Dados['gerente_id'] = (int) $GerenteId;
        $this->Dados['atendimento_funcionario_id'] = (int) $AtendimentoId;
        $this->Dados['funcionario_id'] = (int) $FuncionarioId;
        $this->Dados['data'] = date('Y-m-d H:i:s');

        $this->executarLog();
    }

    public function getRegistrarLog()
    {
        return $this->RegistrarLog;
    }

    /*
     * Registrar log do gerente em ação no atendimento
     */
    private function executarLog()
    {
        $insert = new AdmsCreate();
        $insert->exeCreate("adms_logs_gerente_atividades",$this->Dados);
        $this->RegistrarLog = $insert->getResultado();
    }

}