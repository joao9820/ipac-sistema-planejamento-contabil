<?php
/**
 * Created by PhpStorm.
 * User: Dhemes
 * Date: 15/02/2019
 * Time: 16:09
 */

namespace App\adms\Controllers;

use \App\adms\Models\AdmsAtendimentoStatus;


if (!defined('URL')) {
    header("Location: /");
    exit();
}

class AtendimentoStatus
{

    private $DadosId;
    private $Status;
    private $PageId;
    private $PageVer;
    private $AtendimentoId;
    private $FuncionarioId;

    public function alterar($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        $this->Status = filter_input(INPUT_GET, "status", FILTER_SANITIZE_NUMBER_INT);
        $this->PageId = filter_input(INPUT_GET, "pg", FILTER_SANITIZE_NUMBER_INT);
        $this->PageVer = filter_input(INPUT_GET, "ver", FILTER_SANITIZE_NUMBER_INT);
        $this->AtendimentoId = filter_input(INPUT_GET, 'aten', FILTER_DEFAULT);

        $this->FuncionarioId = filter_input(INPUT_GET, 'func', FILTER_DEFAULT);


        if (!empty($this->DadosId) AND !empty($this->Status) AND !empty($this->PageId) AND !empty($this->AtendimentoId)) {

            $alterarStatus = new AdmsAtendimentoStatus();
            $alterarStatus->alterarStatus($this->DadosId, $this->Status, $this->AtendimentoId, $this->FuncionarioId);


            if (isset($this->PageVer) AND !empty($this->PageVer)) {

                $UrlDestino = URLADM . "funcionario-ver-atendimento/ver/{$this->DadosId}?pg={$this->PageId}";
                header("Location: $UrlDestino");

            } else {

                $UrlDestino = URLADM . "atendimentos/listar/{$this->PageId}?func={$this->FuncionarioId}";
                header("Location: $UrlDestino");

            }
        }
        else {
            $UrlDestino = URLADM . 'atendimentos/listar/1?func='.$this->FuncionarioId;
            header("Location: $UrlDestino");
        }
    }

}