<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:09
 */

namespace App\adms\Controllers;
if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AtendimentoStatus
{

    private $DadosId;
    private $Status;
    private $PageId;

    public function alterar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->Status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);

        if (!empty($this->DadosId) AND ! empty($this->Status) AND ! empty($this->PageId)) {

            $alterarStatus = new \App\adms\Models\AdmsAtendimentoStatus();
            $alterarStatus->alterarStatus($this->DadosId, $this->Status);

            $UrlDestino = URLADM . "atendimento-pendente/listar/{$this->PageId}";
            header("Location: $UrlDestino");
        }
        else {
            $UrlDestino = URLADM . 'atendimento-pendente/listar';
            header("Location: $UrlDestino");
        }
    }

}