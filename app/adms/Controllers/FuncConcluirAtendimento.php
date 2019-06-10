<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:09
 */

namespace App\adms\Controllers;

use App\adms\Models\AdmsFuncConcluirAtendimento;

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

    public function concluir($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->Status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_NUMBER_INT);
        $this->AtendimentoId = filter_input(INPUT_GET, 'aten', FILTER_DEFAULT);

        if (!empty($this->DadosId) AND !empty($this->Status) AND !empty($this->AtendimentoId)) {

            $alterarStatus = new AdmsFuncConcluirAtendimento();
            $alterarStatus->alterar($this->DadosId, $this->Status, $this->AtendimentoId);

            $UrlDestino = URLADM . "atendimentos/listar/{$this->PageId}";
            header("Location: $UrlDestino");
        }
        else {
            $UrlDestino = URLADM . 'atendimentos/listar';
            header("Location: $UrlDestino");
        }
    }

}