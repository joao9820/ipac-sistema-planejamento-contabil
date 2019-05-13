<?php

namespace App\adms\Controllers;

use App\adms\Models\AdmsVerAtendGerente;
use Core\ConfigView;

if (!defined('URL')) {
    header("Location: /");
    exit();
}


class VerAtendimentoModal
{
    private $Dados;
    private $DadosId;

    public function verAtendimento($DadosId = null)
    {
        $this->DadosId = (int) $DadosId;
        if (!empty($this->DadosId)) {
            $verAten = new AdmsVerAtendGerente();
            $this->Dados['atendimento'] = $verAten->visualizar($this->DadosId);
            $this->Dados['total_horas_atendimento'] = $verAten->verTotalHoras($this->Dados['atendimento'][0]['id_demanda']);

            $carregarView = new ConfigView("adms/Views/gerenciar/verAtendimentosModal", $this->Dados);
            $carregarView->renderizarListar();
        }
    }




}
