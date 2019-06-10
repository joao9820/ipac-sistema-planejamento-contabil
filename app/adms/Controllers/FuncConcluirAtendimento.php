<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:09
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsFuncConcluirAtendimento;
use App\adms\Models\AdmsLogGerenteAtendimento;

if (!defined('URL')) {
    header("Location: /");
    exit();
}

class FuncConcluirAtendimento
{

    private $DadosId;
    private $Status;
    private $PageId;
    private $AtendimentoId;
    private $FuncionarioId;

    public function concluir($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->Status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_NUMBER_INT);
        $this->AtendimentoId = filter_input(INPUT_GET, 'aten', FILTER_DEFAULT);

        $this->FuncionarioId = filter_input(INPUT_GET, 'func', FILTER_DEFAULT);

        if (!empty($this->DadosId) AND !empty($this->Status) AND !empty($this->AtendimentoId)) {

            $alterarStatus = new AdmsFuncConcluirAtendimento();
            try {
                $alterarStatus->alterar($this->DadosId, $this->Status, $this->AtendimentoId);
            } catch (\Exception $e) {
                echo "Ocorreu um erro";
            }

            if ($_SESSION['adms_niveis_acesso_id'] < 4) {
                $registrarLogGerente = new AdmsLogGerenteAtendimento(4, $_SESSION['adms_niveis_acesso_id'], $this->DadosId, $this->FuncionarioId);
                if (!$registrarLogGerente->getRegistrarLog()) {
                    echo "Não foi possível registrar o log";
                } else {
                    echo "Log registrado";
                }
            }

            $UrlDestino = URLADM . "atendimentos/listar/{$this->PageId}?func={$this->FuncionarioId}";
            header("Location: $UrlDestino");
        }
        else {
            $UrlDestino = URLADM . 'atendimentos/listar/1?func='.$this->FuncionarioId;
            header("Location: $UrlDestino");
        }
    }

}